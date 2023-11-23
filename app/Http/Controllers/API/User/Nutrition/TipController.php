<?php

namespace App\Http\Controllers\API\User\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Nutrition\TipResource;
use App\Models\Tip;
use App\Traits\ApiResponse;
use Carbon\Carbon;

class TipController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        \request()->headers->set('Accept','application/json');
        Tip::where('status',1)->where('expire_in','<', $now)
            ->update([
                'expire_in'    => NULL
            ]);
    }
    #TODO Refactor
    public function index()
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        $checkValidTip = Tip::where('status',1)->where('expire_in','=', $now)->first();
        if($checkValidTip){
            return $this->coreResponse(" ",200,TipResource::make($checkValidTip),true);
        }
        $tip = Tip::inRandomOrder()->where('status',1)->where('expire_in',NULL)->limit(1)->first();
        if($tip)
        {
            $tip->update([
                'expire_in'   => Carbon::now('Asia/Riyadh')->format('Y-m-d')
            ]);
            return $this->coreResponse(" ",200,TipResource::make($tip),true);
        }
        return $this->coreResponse(" ",200,null,true);
    }
}
