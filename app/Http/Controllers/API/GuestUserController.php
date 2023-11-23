<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CustomerLoginRequest;
use App\Http\Requests\API\OtpCodeVerify;
use App\Http\Requests\API\ResendOtpCodeRequest;
use App\Http\Requests\API\UserDataRequest;
use App\Models\User;
use App\Services\API\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuestUserController extends Controller
{
    use ApiResponse;
    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function register(UserDataRequest $request, UserService $service)
    {
        $user = $service->createNewCustomer($request);
        if(!$user)
            return $this->error(__('api.invalid_data'));
        return $this->success(" ",$user);
    }

    public function verify(OtpCodeVerify $request, UserService $service)
    {
        $verify = $service->verifyUser($request);
        if(!$verify)
            return $this->error(__('api.invalid_data'));
        return $this->success(__('api.user_verified_successfully'),null);
    }

    public function customerLogin(CustomerLoginRequest $request, UserService $service)
    {
        return $service->customerLogin($request);
    }

    /**
     * @param ResendOtpCodeRequest $request
     * @param UserService $service
     * @return \stdClass | string
     */
    public function reSendOtpCode(ResendOtpCodeRequest $request, UserService $service)
    {
        return $service->reSendOtpCode($request);
    }

    public function resetPassword(Request $request)
    {
       $request->validate([
            'mobile'   => 'required|starts_with:5|digits:9|exists:App\Models\User,mobile',
            'otp_code' => 'required|digits:5|numeric|exists:App\Models\User,otp_code',
            'password' => 'required',
        ]);
        $user = User::where('mobile',$request->mobile)->where('otp_code',$request->otp_code)->first();
        if(!$user)
        {
            return $this->error(__('api.invalid_data'));
        }
        $user->update([
           'password'   =>  Hash::make( $request->password),
            'otp_code'  => 1
        ]);
        return $this->success(__('api.password_has_been_changed'),true);
    }
}
