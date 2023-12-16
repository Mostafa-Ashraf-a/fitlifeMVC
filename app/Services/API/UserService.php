<?php

namespace App\Services\API;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserService
{
    use ApiResponse;

    public function createNewCustomer($request)
    {
        $user = User::where('mobile', $request->mobile)->orWhere('email', $request->email)->first();

        if ($user) {
            return false;
        }

        if(config('sms.static_otp')){
            $otpCode = 11111;
        }else{
            $otpCode = rand(10000, 99999);
        }

        $user = User::create([
            'full_name' =>  $request->full_name,
            'email'     =>  $request->email,
            'mobile'    =>  $request->mobile,
            'password'  =>  Hash::make($request->password),
            'otp_code'    =>  $otpCode,
        ]);

        $result = $this->sendSMS($otpCode, $request->mobile);

        $userData = User::where('mobile', $user->mobile)->first();
        $success = $userData;

        $success['sms_result'] = $result;

        $success['token'] = $user->createToken('MyApp', ['customer'])->accessToken;

        $this->createExercisePlan($user);
        return $success;
    }

    public function sendSMS($otpCode, $recipient)
    {
        $mobile = "966" . $recipient;

        $token = config('sms.token');

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $token,
            "Content-Type" => "application/json",
        ])->post('https://app.mobile.net.sa/api/v1/send', [
            "number" => $mobile,
            "senderName" => "Mobile.SA",
            "sendAtOption" => "Now",
            "messageBody" => "كود التحقق: " . $otpCode,
            "allow_duplicate" => true
        ])->json();

        return $response;

        // return \Unifonic::send($mobile, $otpCode);
    }

    public function verifyUser($request): bool
    {
        $user = User::where('mobile', $request->mobile)->where('otp_code', $request->otp_code)->first();
        if (!$user)
            return false;
        $user->update(['otp_code' => 1, 'is_verified' => 1]);
        return true;
    }

    public function customerLogin($request)
    {
        try {
            if (!(auth()->guard('user')->attempt(['mobile' => $request->mobile, 'password' => $request->password])))
                return $this->error("Incorrect Login Information");
            config(['auth.guards.api.provider' => 'users']);
            $customer = User::find(auth()->guard('user')->user()->id);
            return $this->checkCustomerCredentials($customer);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    private function checkCustomerCredentials($customer)
    {
        if (!($customer && $customer->is_verified == 1 && $customer->status == 1))
            return $this->error("Your account is inactive");
        $success = $customer;
        $success['image_url'] = asset('/') . 'assets/images/users/' . $customer->image;
        $success['token'] = $customer->createToken('MyApp', ['customer'])->accessToken;
        return $this->success(" ", $success);
    }

    public function reSendOtpCode($request)
    {
        $user = User::where('mobile', $request->mobile)->first();
        if (!$user)
            return $this->error("Incorrect User Information");

        if ($user->otp_count != 0)
            return $this->error("You have exceeded your verification code usage limit");

        if(config('sms.static_otp')){
            $otpCode = 11111;
        }else{
            $otpCode = rand(10000, 99999);
        }

        $user->update(['otp_code' => $otpCode, 'otp_count' => 1]);

        $this->sendSMS($otpCode, $request->mobile);

        return $this->success("Verification code has been sent successfully", null);
    }

    public function createExercisePlan($user): void
    {
        for ($i = 0; $i <= 6; $i++) {
            DB::table('user_days')->insert([
                'user_id' => $user->id,
                'day_id'  => $i + 1
            ]);
        }
    }
}
