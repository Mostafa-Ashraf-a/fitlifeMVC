<?php

namespace App\Http\Controllers\API;

use App\Filters\UserBodyTrackers\Weight\WeightFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\WeightTrackerRequest;
use App\Http\Resources\WeightTrackerResource;
use App\Models\User;
use App\Models\UserBodyTracker;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WeightTrackerController extends Controller
{
    use ApiResponse;
    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    /**
     * @param WeightFilters $filters
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(WeightFilters $filters)
    {
        $userId = auth()->guard('user-api')->user()->id;
        $weightTracker = UserBodyTracker::filter($filters)
                ->where('weight','!=',null)
                ->where('user_id',$userId)
                ->latest()
               ->get();
        $result = WeightTrackerResource::collection($weightTracker);
        return $this->success(" ",$result);
    }
    public function addNewWeight(WeightTrackerRequest $request)
    {
        try {
            UserBodyTracker::updateOrCreate(
                [
                    'user_id'    => auth()->guard('user-api')->user()->id,
                    'date'       => Carbon::now('Asia/Riyadh')->format('Y-m-d')
                ],
                [
                'user_id'    => auth()->guard('user-api')->user()->id,
                'weight'     => $request->weight,
                'date'       => Carbon::now('Asia/Riyadh')->format('Y-m-d')
                ]
            );
            return $this->success(" ",true);
        }catch (\Exception $exception)
        {
            return $this->error("There's Something Wrong!");
        }
    }
    public function getLastWeight()
    {
        $userId = auth()->guard('user-api')->user()->id;
        $currentDay = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        $currentWeight = UserBodyTracker::where('date',$currentDay)->where('weight','!=',null)->where('user_id',$userId)->latest()->first();
        $lastWeight = UserBodyTracker::where('weight','!=',null)->where('user_id',$userId)->latest()->first();
        $result = [
          'today' => [
              'weight' => $currentWeight->weight ?? null,
              'date' => $currentWeight->date ?? null,
          ],
          'last' => [
              'weight' => $lastWeight->weight ?? null,
              'date'   => $lastWeight->date ?? null,
            ]
        ];
        return $this->success(" ",$result);
    }
    public function getWeightStatistics()
    {
        $userId = auth()->guard('user-api')->user()->id;
        $currentDay = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        $currentWeight = UserBodyTracker::where('date',$currentDay)->where('weight','!=',null)->where('user_id',$userId)->select('weight')->latest()->first();
        $lastWeight = UserBodyTracker::where('weight','!=',null)->where('date','!=',$currentDay)->where('user_id',$userId)->select('weight')->latest()->first();
        $weight = UserBodyTracker::where('weight','!=',null)
            ->where('user_id',$userId)
            ->groupBy('date')
            ->limit(7)
            ->latest()
            ->select('weight')
            ->get();
        $result = 0;
        if ($weight->count() > 0)
        {
            $sum = 0;
            foreach ($weight as $result)
            {
                $sum = $sum + $result['weight'];
            }
            $result = $sum / $weight->count();
                $array = [];
                $diff = [];
                $sumDiff = 0;
                foreach ($weight as $key => $value)
                {
                    $array[] = $value['weight'];
                }
                for ($i = 0; $i < count($array) -1; $i++)
                {
                    $firstValue = $array[$i];
                    $diff[] = $array[$i + 1] - $firstValue;
                }
                for ($i = 0; $i < count($diff); $i++)
                {
                    $sumDiff = $sumDiff + $diff[$i];
                }
        }
        $data = [
            'weekly_average'                       => $result,
            'current_added_weight'                 => $currentWeight ? $currentWeight->weight : 0,
            'last_added_weight'                    => $lastWeight ? $lastWeight->weight : 0,
            'weekly_average_change'                => $sumDiff ?? 0,
        ];
        return $this->success(" ",$data);
    }
}
