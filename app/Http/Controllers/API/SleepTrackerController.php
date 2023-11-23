<?php

namespace App\Http\Controllers\API;

use App\Filters\UserBodyTrackers\Weight\WeightFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\SleepTrackerRequest;
use App\Http\Resources\WeightTrackerResource;
use App\Models\UserBodyTracker;
use App\Traits\ApiResponse;
use App\Traits\General;
use Carbon\Carbon;

class SleepTrackerController extends Controller
{
    use ApiResponse, General;
    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }
    public function index(WeightFilters $filters)
    {
        $userId = auth()->guard('user-api')->user()->id;
        $weightTracker = UserBodyTracker::filter($filters)
            ->where('sleep','!=',null)
            ->orWhere('sleep','!=',0)
            ->where('user_id',$userId)
            ->latest()->get();
        $result = WeightTrackerResource::collection($weightTracker);
        return $this->success(" ",$result);
    }
    public function store(SleepTrackerRequest $request)
    {
        try {
            $today = UserBodyTracker::query()
                ->where('user_id', auth()->guard('user-api')->user()->id)
                ->where('date', Carbon::now('Asia/Riyadh')->format('Y-m-d'))
                ->first();
            if($today)
            {
                $today->update([
                    'sleep'  => $today->sleep + $request->sleep
                ]);
            }else{
                UserBodyTracker::create([
                    'user_id'    => auth()->guard('user-api')->user()->id,
                    'sleep'      => $request->sleep,
                    'date'       => Carbon::now('Asia/Riyadh')->format('Y-m-d')
                ]);
            }
            return $this->success(" ",true);
        }catch (\Exception $exception)
        {
            return $this->error("There's Something Wrong!");
        }
    }
    public function show()
    {
        try {
            $currentDay = Carbon::now('Asia/Riyadh')->format('Y-m-d');
            $result = UserBodyTracker::where('user_id', auth()->guard('user-api')->user()->id)
                ->where('sleep', '!=', null)
                ->where('date', $currentDay)
                ->sum('sleep');
            return $this->success(" ",$result);
        }catch (\Exception $exception)
        {
            return $this->error("There's Something Wrong!");
        }
    }
}
