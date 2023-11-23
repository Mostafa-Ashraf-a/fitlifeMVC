<?php


namespace App\Services\API\User\Nutrition;

use App\Models\FoodExchange;
use App\Models\Meal;
use App\Models\Serving as ServingModel;
use App\Models\UserMealPlan as UserMealPlanModel;
use App\Traits\ApiResponse;

class MealService
{
    use ApiResponse;

    const  UNDER_CONSTRUCTION   = 1;

    const  MASTER_SERVING       = 1;
    const  USED_SERVING         = 2;

    const  STARCHES_SERVING     = 1;
    const  FRUITS_SERVING       = 2;
    const  VEGETABLES_SERVING   = 3;
    const  MEATS_SERVING        = 4;
    const  DAIRY_SERVING        = 5;
    const  OILS_SERVING         = 6;

    public function createUserMeal($request, $user) : void
    {
        $meal = $this->saveMeal($request);
        $this->saveUserMeal($request, $meal,$user);
    }

    public function updateUserMeal($request, $user, $meal) : void
    {
        $this->updateMeal($request, $meal);
        $this->updateMealServing($request, $meal, $user);
    }

    public function updateMealServing($request, $meal, $user)
    {
        foreach ($request->foodExchanges as $foodExchange)
        {
            $this->createOrUpdateUserMeal($meal, $user, $foodExchange);
            # TODO it's wrong here need to fix it
            $this->updateServing($foodExchange['food_exchange_id'], $user, $foodExchange['quantity']);
        }
    }

    public function updateServing($foodExchangeId, $user, $quantity)
    {
        $serving = ServingModel::query()
            ->where('user_id', $user->id)
            ->where('status', self::MASTER_SERVING)
            ->first();
        $checkUsedServing = ServingModel::query()
            ->where('user_id', $user->id)
            ->where('status', self::USED_SERVING)
            ->where('plan_status', self::UNDER_CONSTRUCTION)
            ->first();
        if(!$checkUsedServing)
        {
            ServingModel::updateOrCreate(
                [
                    'user_id'       => $user->id,
                    'status'        => self::USED_SERVING,
                    'plan_status'   => self::UNDER_CONSTRUCTION
                ],
                [
                    'user_id'       => $user->id,
                    'status'        => self::USED_SERVING,
                    'plan_status'   => self::UNDER_CONSTRUCTION,
                    'starches'      => 0,
                    'fruits'        => 0,
                    'vegetables'    => 0,
                    'meats'         => 0,
                    'dairy'         => 0,
                    'oils'          => 0,
                ]
            );
        }
        $usedServing = ServingModel::query()
            ->where('user_id', $user->id)
            ->where('status', self::USED_SERVING)
            ->where('plan_status', self::UNDER_CONSTRUCTION)
            ->first();
        $foodExchangeModel = FoodExchange::where('id',$foodExchangeId)->first();

        if ($foodExchangeModel->foodType->id == self::STARCHES_SERVING && isset($usedServing) && ($quantity <= (integer)$serving->starches))
        {
            $usedServing->update(['starches' => $quantity]);
        }

        if ($foodExchangeModel->foodType->id == self::FRUITS_SERVING && isset($usedServing) && ($quantity <= (integer)$serving->fruits))
        {
            $usedServing->update(['fruits' => $quantity]);
        }

        if ($foodExchangeModel->foodType->id == self::VEGETABLES_SERVING && isset($usedServing) && ($quantity <= (integer)$serving->vegetables))
        {
            $usedServing->update(['vegetables' => $quantity]);
        }

        if ($foodExchangeModel->foodType->id == self::MEATS_SERVING && isset($usedServing) && ($quantity <= (integer)$serving->meats))
        {
            $usedServing->update(['meats' => $quantity]);
        }
        if ($foodExchangeModel->foodType->id == self::DAIRY_SERVING && isset($usedServing) && ($quantity <= (integer)$serving->dairy))
        {
            $usedServing->update(['dairy' => $quantity]);
        }

        if ($foodExchangeModel->foodType->id == self::OILS_SERVING && isset($usedServing) && ($quantity <= (integer)$serving->dairy))
        {
            $usedServing->update(['oils' => $quantity]);
        }
    }

    private function updateMeal($request, $meal)
    {
        return $meal->update([
            'ar' => ['title' => $request->title],
            'en' => ['title' => $request->title],
        ]);
    }

    private function saveMeal($request)
    {
        return Meal::create([
            'ar' => ['title' => $request->title],
            'en' => ['title' => $request->title],
            'is_default'  => 2
        ]);
    }

    /**
     * @param $request
     * @param $meal
     * @param $user
     */

    private function saveUserMeal($request, $meal, $user) : void
    {
        foreach ($request->foodExchanges as $foodExchange)
        {
            $this->createOrUpdateUserMeal($meal, $user, $foodExchange);
            $this->calculateServing($foodExchange['food_exchange_id'], $user, $foodExchange['quantity']);
        }
    }

    #TODO Refactor
    #TODO Check the quantity in case be 0
    private function calculateServing($foodExchangeId, $user, $quantity)
    {
        $serving = ServingModel::query()
            ->where('user_id', $user->id)
            ->where('status', self::MASTER_SERVING)
            ->first();
        $checkUsedServing = ServingModel::query()
            ->where('user_id', $user->id)
            ->where('status', self::USED_SERVING)
            ->where('plan_status', self::UNDER_CONSTRUCTION)
            ->first();
        if(!$checkUsedServing)
        {
            ServingModel::updateOrCreate(
                [
                    'user_id'       => $user->id,
                    'status'        => self::USED_SERVING,
                    'plan_status'   => self::UNDER_CONSTRUCTION
                ],
                [
                    'user_id'       => $user->id,
                    'status'        => self::USED_SERVING,
                    'plan_status'   => self::UNDER_CONSTRUCTION,
                    'starches'      => 0,
                    'fruits'        => 0,
                    'vegetables'    => 0,
                    'meats'         => 0,
                    'dairy'         => 0,
                    'oils'          => 0,
                ]
            );
        }
        $usedServing = ServingModel::query()
            ->where('user_id', $user->id)
            ->where('status', self::USED_SERVING)
            ->where('plan_status', self::UNDER_CONSTRUCTION)
            ->first();
        $foodExchangeModel = FoodExchange::withTranslation()->where('id',$foodExchangeId)->first();
        if ($foodExchangeModel->foodType->id == self::STARCHES_SERVING)
        {
            if(isset($usedServing) && (integer)$usedServing->starches != 0)
            {
                if($serving->starches == ((integer)$usedServing->starches))
                {
                    return $this->error(" ", 400);
                }else{
                    $usedServing->update([
                        'starches' => (integer)$usedServing->starches + $quantity
                    ]);
                }
            }else{

                $usedServing->update([
                    'starches' => $quantity
                ]);
            }
        }
        if ($foodExchangeModel->foodType->id == self::FRUITS_SERVING)
        {
            if(isset($usedServing) && (integer)$usedServing->fruits != 0)
            {
                if($serving->fruits == ((integer)$usedServing->fruits))
                {
                    return $this->error(" ", 400);
                }else{
                    $usedServing->update([
                        'fruits' => (integer)$usedServing->fruits + $quantity
                    ]);
                }
            }else{
                $usedServing->update([
                    'fruits' => $quantity
                ]);
            }
        }
        if ($foodExchangeModel->foodType->id == self::VEGETABLES_SERVING)
        {
            if(isset($usedServing) && (integer)$usedServing->vegetables != 0)
            {
                if($serving->vegetables == ((integer)$usedServing->vegetables))
                {
                    return $this->error(" ", 400);
                }else{
                    $usedServing->update([
                        'vegetables' => (integer)$usedServing->vegetables + $quantity
                    ]);
                }
            }else{
                $usedServing->update([
                    'vegetables' => $quantity
                ]);
            }
        }
        if ($foodExchangeModel->foodType->id == self::MEATS_SERVING)
        {
            if(isset($usedServing) && (integer)$usedServing->meats != 0)
            {
                if($serving->meats == ((integer)$usedServing->meats))
                {
                    return $this->error(" ", 400);
                }else{
                    $usedServing->update([
                        'meats' => (integer)$usedServing->meats + $quantity
                    ]);
                }
            }else{
                $usedServing->update([
                    'meats' => $quantity
                ]);
            }
        }
        if ($foodExchangeModel->foodType->id == self::DAIRY_SERVING)
        {
            if(isset($usedServing) && (integer)$usedServing->dairy != 0)
            {
                if($serving->dairy == ((integer)$usedServing->dairy))
                {
                    return $this->error(" ", 400);
                }else{
                    $usedServing->update([
                        'dairy' => (integer)$usedServing->dairy + $quantity
                    ]);
                }
            }else{
                $usedServing->update([
                    'dairy' => $quantity
                ]);
            }
        }
        if ($foodExchangeModel->foodType->id == self::OILS_SERVING)
        {
            if(isset($usedServing) && (integer)$usedServing->oils != 0)
            {
                if($serving->oils == ((integer)$usedServing->oils))
                {
                    return $this->error(" ", 400);
                }else{
                    $usedServing->update([
                        'oils' => (integer)$usedServing->oils + $quantity
                    ]);
                }
            }else{
                $usedServing->update([
                    'oils' => $quantity
                ]);
            }
        }
    }

    /**
     * @param $meal
     * @param $user
     * @param $foodExchange
     */
    private function createOrUpdateUserMeal($meal, $user, $foodExchange): void
    {
        UserMealPlanModel::updateOrCreate(
            [
                'meal_id'          => $meal->id,
                'user_id'          => $user->id,
                'food_exchange_id' => $foodExchange['food_exchange_id'],
                'status'           => self::UNDER_CONSTRUCTION,
            ],
            [
                'meal_id'          => $meal->id,
                'user_id'          => $user->id,
                'food_exchange_id' => $foodExchange['food_exchange_id'],
                'quantity'         => $foodExchange['quantity'],
                'status'           => self::UNDER_CONSTRUCTION,
            ]
        );
    }

    public function deleteFoodExchange($user, $foodExchange, $meal) : bool
    {
        $status = false;
        $userMealPlan = UserMealPlanModel::where(
            [
                'meal_id'          => $meal->id,
                'user_id'          => $user->id,
                'food_exchange_id' => $foodExchange->id,
                'status'           => self::UNDER_CONSTRUCTION,
            ],
        )->first();
        if($userMealPlan)
        {
            $this->incrementUserServing($userMealPlan, $foodExchange);
            $status = $userMealPlan->delete();
        }
        return $status;
    }

    # TODO check the incoming request when the user delete all food exchanges
    private function incrementUserServing($userMealPlan, $foodExchange) : void
    {
        $usedServing = ServingModel::query()
            ->where('user_id', $userMealPlan->user_id)
            ->where('status', self::USED_SERVING)
            ->where('plan_status', self::UNDER_CONSTRUCTION)
            ->first();
        if($foodExchange->foodType->id == self::STARCHES_SERVING)
        {
            $usedServing->update([
                'starches' => $usedServing->starches - $userMealPlan->quantity
            ]);
        }
        if ($foodExchange->foodType->id == self::FRUITS_SERVING)
        {
            $usedServing->update([
                'fruits' => $usedServing->id - $userMealPlan->quantity
            ]);
        }
        if ($foodExchange->foodType->id == self::VEGETABLES_SERVING)
        {
            $usedServing->update([
                'vegetables' => $usedServing->vegetables - $userMealPlan->quantity
            ]);
        }
        if ($foodExchange->foodType->id == self::MEATS_SERVING)
        {
            $usedServing->update([
                'meats' => $usedServing->meats - $userMealPlan->quantity
            ]);
        }
        if ($foodExchange->foodType->id == self::DAIRY_SERVING)
        {
            $usedServing->update([
                'dairy' => $usedServing->dairy - $userMealPlan->quantity
            ]);
        }
        if ($foodExchange->foodType->id == self::OILS_SERVING)
        {
            $usedServing->update([
                'oils' => $usedServing->oils - $userMealPlan->quantity
            ]);
        }
    }
}
