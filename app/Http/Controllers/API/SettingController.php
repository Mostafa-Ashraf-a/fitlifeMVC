<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Traits\ApiResponse;

class SettingController extends Controller
{
    use ApiResponse;
    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function index()
    {
        $setting = Setting::first();
        return $this->success(" ",new SettingResource($setting));
    }
}
