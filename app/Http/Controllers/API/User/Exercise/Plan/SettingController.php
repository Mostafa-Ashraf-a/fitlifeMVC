<?php

namespace App\Http\Controllers\API\User\Exercise\Plan;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\Exercise\Plan\SettingRequest;
use App\Services\API\User\Exercise\Plan\SettingService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ApiResponse;

    private $service;

    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(SettingRequest $request)
    {
        $this->service->store($request);
        return $this->success(" ",true);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
