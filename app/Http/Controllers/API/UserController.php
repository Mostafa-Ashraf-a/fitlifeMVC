<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\Profile\ChangeProfileInfoRequest;
use App\Http\Requests\API\User\Profile\ChangeProfilePictureRequest;
use App\Http\Resources\User\UserInformation\ProfileResource;
use App\Services\API\User\Profile\ProfileService;
use App\Traits\ApiResponse;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponse, General;
    private $service;
    public function __construct(ProfileService $service)
    {
        \request()->headers->set('Accept','application/json');
        $this->service = $service;
    }

    public function changePassword(Request $request)
    {
        $user = auth()->guard('user-api')->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);
        if ((Hash::check($request->old_password, $user->password)) == false) {
            return $this->error(__('api.old_password_incorrect'));
        } else {
            $user->update(['password' => Hash::make($request->new_password)]);
            return $this->success(__('api.updated_successfully'), true);
        }
    }

    public function update(ChangeProfileInfoRequest $request)
    {
        $user = auth()->guard('user-api')->user();
        $user->update([
            'mobile'   => $request->mobile,
            'email'   => $request->email
        ]);
        return $this->success(__('api.updated_successfully'),null);
    }

    public function changeProfilePicture(ChangeProfilePictureRequest $request)
    {
        $user = auth()->guard('user-api')->user();
        $this->service->updateProfileImage($request, $user);
        return $this->success(__('api.updated_successfully'),null);
    }

    public function profile()
    {
        $user = auth()->guard('user-api')->user();
        return $this->success(" ", ProfileResource::make($user));
    }

    public function deactivateAccount()
    {
        $user = auth()->guard('user-api')->user();
        $user->token()->revoke();
        $user->delete();
        return $this->success(__('api.delete_account'),true);
    }
}
