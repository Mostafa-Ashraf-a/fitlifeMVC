<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AuthCustomerController extends Controller
{
    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }
    use ApiResponse;
    public function customerLogout()
    {
        try{
            $user = auth()->guard('user-api')->user();
            $user->token()->revoke();
            return $this->success("Signed out successfully", null);
        }
        catch(\Exception $e){
            return $this->error("There's something wrong");
        }
    }
}
