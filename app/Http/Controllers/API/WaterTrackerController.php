<?php

namespace App\Http\Controllers\API;

use App\Filters\UserBodyTrackers\Weight\WeightFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\WaterTrackerRequest;
use App\Http\Resources\WeightTrackerResource;
use App\Models\UserBodyTracker;
use App\Traits\ApiResponse;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WaterTrackerController extends Controller
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
            ->where('water','!=',null)
            ->where('water','!=',0)
            ->where('user_id',$userId)
            ->latest()->get();
        $result = WeightTrackerResource::collection($weightTracker);
        return $this->success(" ",$result);
    }
    public function store(WaterTrackerRequest $request)
    {
        try {
            $today = UserBodyTracker::query()
                ->where('user_id', auth()->guard('user-api')->user()->id)
                ->where('date', Carbon::now('Asia/Riyadh')->format('Y-m-d'))
                ->first();
            if($today)
            {
                $today->update([
                   'water'  => $today->water + $request->water
                ]);
            }else{
                UserBodyTracker::create([
                    'user_id'    => auth()->guard('user-api')->user()->id,
                    'water'      => $request->water,
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
                ->where('water', '!=', null)
                ->where('date', $currentDay)
                ->sum('water');
//            $resultPerLiter = $this->convertToLiter($water);
//            $result = ($resultPerLiter / 2.9) * 100;
            return $this->success(" ",$result);
        }catch (\Exception $exception)
        {
            return $this->error("There's Something Wrong!");
        }
    }

    /**
     * For Water Lost During The Exercise and should be taken After Exercise
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateWaterIntake(Request $request)
    {
        $request->validate([
            'weight_before_training' => 'required|numeric',
            'weight_after_training' => 'required|numeric',
        ]);
        $waterIntake = ($request->weight_before_training - $request->weight_after_training) * 500;
        $data = [
            "water_lost_during_exercise" => [
                "water_intake_after_exercise" => $waterIntake,
                "serving_of_starches" => [
                    "Calories" => 80,
                    "Carbs"    => 15,
                    "Protein"  => 3,
                ],
                "serving_of_fruits" => [
                    "Calories" => 60,
                    "Carbs"    => 15,
                ],
                "serving_of_vegetables" => [
                    "Calories"  => 25,
                    "Carbs"     => 5,
                    "Protein"   => 2,
                ],
                "serving_of_meat_or_protein_sources" => [
                    "Calories" => 75,
                    "Carbs"    => 12,
                    "Protein"  => 7,
                    "Fats"     => 5,
                ],
                "serving_of_milk_or_milk_products" => [
                    "Calories" => 120,
                    "Carbs"    => 12,
                    "Protein"  => 8,
                    "Fats"     => 5,
                ],
                "tea_spoon_of_veg_oil" => [
                    "Calories" => 40,
                    "Fats"     => 5,
                ],
            ],
        ];
        return $this->success(" ",$data);
    }
}
