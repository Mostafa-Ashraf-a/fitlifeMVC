<?php


namespace App\Services\API;



use App\Models\CalculationResult;
use App\Models\Serving as ServingModel;
use App\Models\User;
use App\Models\UserBodyTracker;
use App\Models\UserCalculationField;
use App\Traits\ApiResponse;
use Carbon\Carbon;

class QuestionnaireService
{
    use ApiResponse;
    const  MASTER_SERVING                      = 1;
    const  MASTER_SERVING_NEW_USER_PLAN_STATUS = 0;

    private function storeQuestionAnswers($request, $result): bool
    {
        $userId = auth()->guard('user-api')->user()->id;
        $user = User::find($userId);

        $user->calculationResult()->detach();
        $user->calculationResult()->attach($request->question_1['question_id'], ['answer_id' => $request->question_1['answer_id']]);
        $user->calculationResult()->attach($request->question_2['question_id'], ['answer_id' => $request->question_2['answer_id']]);
        if ($request->question_3 != null) {
            $user->calculationResult()->attach($request->question_3['question_id'], ['answer_id' => $request->question_3['answer_id']]);
        }
        if ($request->question_4 != null) {
            $user->calculationResult()->attach($request->question_4['question_id'], ['answer_id' => $request->question_4['answer_id']]);
        }
        if ($request->question_5 != null) {
            $user->calculationResult()->attach($request->question_5['question_id'], ['answer_id' => $request->question_5['answer_id']]);
        }
        UserCalculationField::updateOrCreate(
            ['user_id' => $userId],
            [
                'user_id'                      => $userId,
                'macronutrients_amount_answer' => $request->new_macronutrients_amount['answer'] ?? null,
                'protein_intake'               => $request->new_macronutrients_amount['protein_intake'] ?? null,
                'carbs_intake'                 => $request->new_macronutrients_amount['carbs_intake'] ?? null,
                'fats_intake'                  => $request->new_macronutrients_amount['fats_intake'] ?? null,
                'body_fat_percentage_answer'   => $request->body_fat_percentage_details['answer'] ?? null,
                'waist_circumference'          => $request->body_fat_percentage_details['waist_circumference'] ?? null,
                'neck_circumference'           => $request->body_fat_percentage_details['neck_circumference'] ?? null,
                'hip_circumference'            => $request->body_fat_percentage_details['hip_circumference'] ?? null,
            ]
        );
        CalculationResult::updateOrCreate(
            ['user_id' => $userId],
            [
                'user_id'               => $userId,
                'daily_calories_goal'   => $result['daily_calories']['your_daily_calories_for_your_goal_is'] ?? null,
                'min_daily_calories'    => $result['daily_calories']['min_daily_calories'] ?? null,
                'max_daily_calories'    => $result['daily_calories']['max_daily_calories'] ?? null,
                'body_mass_index'       => $result['BMI']['body_mass_index'] ?? null,
                'body_mass_index_text'  => $result['BMI']['body_mass_index_text'] ?? null,
                'protein_calories'      => $result['your_macronutrients_in_calories_are']['Protein'] ?? null,
                'carbs_calories'        => $result['your_macronutrients_in_calories_are']['Carbs'] ?? null,
                'fats_calories'         => $result['your_macronutrients_in_calories_are']['Fats'] ?? null,
                'protein_grams'         => $result['your_macronutrients_in_grams_are']['Protein'] ?? null,
                'carbs_grams'           => $result['your_macronutrients_in_grams_are']['Carbs'] ?? null,
                'fats_grams'            => $result['your_macronutrients_in_grams_are']['Fats'] ?? null,
                'approximated_body_fat_percentage_based_on_bmi' => $result['approximated_body_fat_percentage_based_on_BMI'] ?? null,
                'new_macronutrients_in_calories_protein'  => $result['new_macronutrients']['your_macronutrients_in_calories_are']['Protein'] ?? null,
                'new_macronutrients_in_calories_carbs'    => $result['new_macronutrients']['your_macronutrients_in_calories_are']['Carbs'] ?? null,
                'new_macronutrients_in_calories_fats'     => $result['new_macronutrients']['your_macronutrients_in_calories_are']['Fats'] ?? null,
                'new_macronutrients_in_grams_protein'     => $result['new_macronutrients']['your_macronutrients_in_grams_are']['Protein'] ?? null,
                'new_macronutrients_in_grams_carbs'       => $result['new_macronutrients']['your_macronutrients_in_grams_are']['Carbs'] ?? null,
                'new_macronutrients_in_grams_fats'        => $result['new_macronutrients']['your_macronutrients_in_grams_are']['Fats'] ?? null,
                'body_fat_percentage_yes'     => $result['body_fat_percentage_details_yes']['body_fat_percentage'] ?? null,
                'fat_mass_yes'       => $result['body_fat_percentage_details_yes']['fat_mass'] ?? null,
                'lean_mass_yes'        => $result['body_fat_percentage_details_yes']['lean_mass'] ?? null,
                'body_fat_percentage_no'     => $result['body_fat_percentage_details_no']['body_fat_percentage'] ?? null,
                'fat_mass_no'                => $result['body_fat_percentage_details_no']['fat_mass'] ?? null,
                'lean_mass_no'               => $result['body_fat_percentage_details_no']['lean_mass'] ?? null,
                'water_intake_after_exercise'  => $result['water_lost_during_exercise']['water_intake_after_exercise'] ?? null,
                'starches'            => $result['Servings']['starches'] ?? null,
                'fruits'              => $result['Servings']['fruits'] ?? null,
                'vegetables'          => $result['Servings']['vegetables'] ?? null,
                'meats'               => $result['Servings']['meats'] ?? null,
                'dairy'               => $result['Servings']['dairy'] ?? null,
                'oils'                => $result['Servings']['oils'] ?? null,
                'total_calories'      => $result['Servings']['total_calories'] ?? null,
                'total_protein'       => $result['Servings']['total_protein'] ?? null,
                'total_carbs'         => $result['Servings']['total_carbs'] ?? null,
                'total_fats'          => $result['Servings']['total_fats'] ?? null,
                'starches_result'     => $result['Servings']['result']['starches'] ?? null,
                'fruits_result'       => $result['Servings']['result']['fruits'] ?? null,
                'vegetables_result'   => $result['Servings']['result']['vegetables'] ?? null,
                'meats_result'        => $result['Servings']['result']['meats'] ?? null,
                'dairy_result'        => $result['Servings']['result']['dairy'] ?? null,
                'oils_result'         => $result['Servings']['result']['oils'] ?? null,
            ]
        );
        return true;
    }
    /**
     * questionnaire calculation
     * @param $request
     * @return \stdClass|string
     */


     public function questionnaireCalculation($request)
    {
        try {
            UserBodyTracker::create(
                [
                    'user_id' => auth()->guard('user-api')->user()->id,
                    'weight' => $request->customer_info['weight'],
                    'date' => Carbon::now('Asia/Riyadh')->format('Y-m-d')
                ]
            );


            $bodyMassIndex       = $this->calculateBodyMassIndex($request->customer_info);
            $idealHeight         = 21.5 * pow(($request->customer_info['height'] / 100), 2);
            $dailyCalories       = $this->calculateDailyCalories($bodyMassIndex, $request, $idealHeight);
            $checkGainWeight     = $this->checkGainWeight($request, $dailyCalories);

            User::findOrFail(auth()->guard('user-api')->user()->id)->update([
                'age' => $request->customer_info['age'],
                'gender' => $request->customer_info['gender'],
                'goal' => $request->question_1['answer_id'],
                'weight' => $request->customer_info['weight'],
                'height' => $request->customer_info['height'],
                'level' => $request->question_3['answer_id'] ?? null,
            ]);

            ServingModel::updateOrCreate(
                [
                    'user_id'      => auth()->guard('user-api')->user()->id,
                    'status'       => self::MASTER_SERVING,
                    'plan_status'  => self::MASTER_SERVING_NEW_USER_PLAN_STATUS,
                ],
                [
                    'user_id'             => auth()->guard('user-api')->user()->id,
                    'status'              => self::MASTER_SERVING,
                    'plan_status'         => self::MASTER_SERVING_NEW_USER_PLAN_STATUS,
                    'starches'            => $checkGainWeight['Servings']['starches'],
                    'fruits'              => $checkGainWeight['Servings']['fruits'],
                    'vegetables'          => $checkGainWeight['Servings']['vegetables'],
                    'meats'               => $checkGainWeight['Servings']['meats'],
                    'dairy'               => $checkGainWeight['Servings']['dairy'],
                    'oils'                => $checkGainWeight['Servings']['oils'],
                ]
            );

            $this->storeQuestionAnswers($request, $checkGainWeight);
            $result = $checkGainWeight;
            return $this->success(" ", $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @param $customerInfo
     * @return float
     */
    private function calculateBodyMassIndex($customerInfo): float
    {
        $weight = $customerInfo['weight'];
        $height = $customerInfo['height'];
        return $weight / pow(($height / 100), 2);
    }

    /**
     * @param $bodyMassIndex
     * @return string
     */
    private function getBodyMassIndexText($bodyMassIndex): string
    {
        $text = '';
        if ($bodyMassIndex < 18.5) {
            $text = __('api.you_are_under_weight');
        } elseif (18 <= $bodyMassIndex && $bodyMassIndex < 25) {
            $text = __('api.you_have_a_normal_weight');
        } elseif (25 <= $bodyMassIndex && $bodyMassIndex < 30) {
            $text = __('api.you_are_over_weight');
        } else {
            $text = __('api.you_are_obese');
        }
        return $text;
    }

    /**
     * @param $bodyMassIndex
     * @param $request
     * @param $idealHeight
     * @return array
     */

     //done
    private function calculateDailyCalories($bodyMassIndex, $request, $idealHeight): array
    {
        $dailyCalories = 0;
        $activityFactor = 0;
        $bodyBuildingLevel = null;

        if (isset($request->question_3['answer_id']) != null) {
            $bodyBuildingLevel = $request->question_3['answer_id'];
        }



        if ($bodyMassIndex < 18.5 || $bodyMassIndex > 25) {
            if ($request->customer_info['gender'] == 1) {
                $dailyCalories = round(66.5 + (13.75 * $idealHeight) + (5.0031 * $request->customer_info['height']) - (6.755 * $request->customer_info['age']), 2);
            } else {
                $dailyCalories = round(665 + (9.563 * $idealHeight) + (1.850 * $request->customer_info['height']) - (4.676 * $request->customer_info['age']), 2);
            }
        } else {
            if ($request->customer_info['gender'] == 1) {
                $dailyCalories = round(66.5 + (13.75 * $request->customer_info['weight']) + (5.0031 * $request->customer_info['height']) - (6.755 * $request->customer_info['age']), 2);
            } else {
                $dailyCalories = round(665 + (9.563 * $request->customer_info['weight']) + (1.850 * $request->customer_info['height']) - (4.676 * $request->customer_info['age']), 2);
            }
        }

        if ($request->question_2['answer_id'] == 4) {
            $activityFactor = 1.2;
            $bodyBuildingLevel = 4;
        } elseif ($request->question_2['answer_id'] == 5) {
            $activityFactor = 1.35;
        } elseif ($request->question_2['answer_id'] == 6) {
            $activityFactor = 1.5;
        } elseif ($request->question_2['answer_id'] == 7) {
            $activityFactor = 1.7;
        }


        $dailyCalories = round($activityFactor * $dailyCalories, 2);

        if ($bodyMassIndex < 18.5 || $bodyMassIndex > 25) {
            if ($request->question_1['answer_id'] == 3) {
                $minDailyCalories = $dailyCalories - 500; // minc == $minDailyCalories && cn == $dailyCalories
                $maxDailyCalories = $dailyCalories;      //maxc == $maxDailyCalories   && cn = $dailyCalories
            } elseif ($request->question_1['answer_id'] == 2) {
                $minDailyCalories = $dailyCalories;
                $maxDailyCalories = $dailyCalories + 500;
            } elseif ($request->question_1['answer_id'] == 1) {
                $minDailyCalories = $dailyCalories;
                $maxDailyCalories = $dailyCalories;
            }
        } else {
            if ($request->question_1['answer_id'] == 3) {
                $minDailyCalories = $dailyCalories - 500; // minc == $minDailyCalories && cn == $dailyCalories
                $maxDailyCalories = $dailyCalories;      //maxc == $maxDailyCalories   && cn = $dailyCalories
            } elseif ($request->question_1['answer_id'] == 2) {
                $minDailyCalories = $dailyCalories;
                $maxDailyCalories = $dailyCalories + 500;
            } elseif ($request->question_1['answer_id'] == 1) {
                $minDailyCalories = $dailyCalories;
                $maxDailyCalories = $dailyCalories;
            }
        }
        return [
            "daily_calories_result"      => $dailyCalories,
            "min_daily_calories"         => $minDailyCalories,
            "max_daily_calories"         => $maxDailyCalories,
            "goal"                       => $request->question_1['answer_id'],
            "body_mass_index"            => $bodyMassIndex,
            "ideal_height"               => $idealHeight,
            "body_building_level"        => $bodyBuildingLevel,
        ];
    }

    /**
     * @param $request
     * @param $dailyCalories
     * @return array
     */
    private function checkGainWeight($request, $dailyCalories)
    {
        $finalDailyCalories = 0;
        $actualWeight = $request->customer_info['weight'];
        $dailyCaloriesResultCN = $dailyCalories['daily_calories_result'];
        $minDailyCaloriesResultCN = $dailyCalories['min_daily_calories'];
        $maxDailyCaloriesResultCN = $dailyCalories['max_daily_calories'];

        if (isset($request->question_4['question_id']) != null) {
            $finalDailyCalories = $request->question_4['question_id'];
            if ($finalDailyCalories == 4 && $request->question_4['answer_id'] == 11) // check gain && 0.5 Kg per Week
            {
                $dailyCaloriesResultCN = $minDailyCaloriesResultCN;
            } else {
                $dailyCaloriesResultCN = $dailyCalories['max_daily_calories'];
            }
        } elseif (isset($request->question_5['question_id']) != null) {
            $finalDailyCalories = $request->question_5['question_id'];
            if ($finalDailyCalories == 5 && $request->question_5['answer_id'] == 13) // check lose && 0.5 Kg per Week
            {
                $dailyCaloriesResultCN = $maxDailyCaloriesResultCN;
            } else {
                $dailyCaloriesResultCN = $minDailyCaloriesResultCN;
            }
        } elseif ($dailyCalories['goal'] == 1) {
            $finalDailyCalories = $dailyCaloriesResultCN;
        }

        if ($dailyCalories['body_mass_index'] > 25) {
            $actualWeight = $dailyCalories['ideal_height'];
        }

        $factor     = 0;
        $min        = 2;
        $percentage = 0;

        switch ([$dailyCalories['goal'], $dailyCalories['body_building_level']]) {
            case [1, 8]:
                $factor     = 1.7;
                $min        = 1;
                $percentage = 0.18;
                break;
            case [1, 9]:
                $factor     = 2;
                $min        = 1;
                $percentage = 0.25;
                break;
            case [1, 10]:
                $factor     = 2.5;
                $min        = 1;
                $percentage = 0.30;
                break;
            case [1, 4]:
                $factor     = 1.5;
                $min        = 1;
                $percentage = 0.20;
                break;
            case [2, 8]:
                $factor     = 2;
                $min        = 1;
                $percentage = 0.18;
                break;
            case [2, 9]:
                $factor     = 2.7;
                $min        = 1;
                $percentage = 0.25;
                break;
            case [2, 10]:
                $factor     = 3;
                $min        = 1;
                $percentage = 0.30;
                break;
            case [2, 4]:
                $factor     = 0;
                $min        = 1;
                $percentage = 0.20;
                break;
            case [3, 8]:
                $factor     = 0;
                $min        = 0;
                $percentage = 0.20;
                break;
            case [3, 9]:
                $factor     = 0;
                $min        = 0;
                $percentage = 0.25;
                break;
            case [3, 10]:
                $factor     = 0;
                $min        = 0;
                $percentage = 0.30;
                break;
            case [3, 4]:
                $factor     = 0;
                $min        = 0;
                $percentage = 0.20;
                break;
        }


        if ($dailyCaloriesResultCN < 1200 || $minDailyCaloriesResultCN < 1200) {
            $dailyCaloriesResultCN    = 1200;
            $minDailyCaloriesResultCN = 1200;
        }

        if ($factor != 0) {
            $factorEqualZero           = "No";
            $percentageValue           = $percentage;
            $minValue                  = 1;
            $factorValue               = $factor;
            $minDailyCaloriesResultCN  = $dailyCaloriesResultCN;
            $proteinFromPercentage     = ($dailyCaloriesResultCN * $percentage) / 4;
            $proteinFromFactor         = $factor * $actualWeight;
            if ($proteinFromPercentage < $proteinFromFactor) {
                $protein = $proteinFromPercentage;
            } else {
                $protein = $proteinFromFactor;
            }
            $proteinC       = round($protein * 4, 2);
            $proteinPercent = round($proteinC / $dailyCaloriesResultCN, 2);
            $proteinPerKg   = $protein / $actualWeight;
            $fatsC          = 0.30 * $dailyCaloriesResultCN;
            $fatsQ          = round($fatsC / 9, 2);
            $carbsC = $dailyCaloriesResultCN - ($proteinC + $fatsC);
            $carbsQ = round($carbsC / 4, 2);

        } else {
            $factorEqualZero           = "Yes";
            $percentageValue           = $percentage;
            $minValue                  = 0;
            $factorValue               = $factor;
            $proteinFromPercentage     = ($dailyCaloriesResultCN * $percentage) / 4;
            $protein = $proteinFromPercentage;
            $proteinPerKg   = $protein / $actualWeight;
            $proteinC       = round($protein * 4, 2);
            $proteinPercent = round($proteinC / $dailyCaloriesResultCN, 2);
            $fatsC          = round(0.30 * $dailyCaloriesResultCN, 2);
            $fatsQ          = round($fatsC / 9, 2);
            $carbsC = $dailyCaloriesResultCN - ($proteinC + $fatsC);
            $carbsQ = round($carbsC / 4, 2);
        }
        if ($request->customer_info['gender'] == 1) {
            $BFP = 1.20 * $dailyCalories['body_mass_index'] + 0.23 * $request->customer_info['age'] - 16.2;
        } elseif ($request->customer_info['gender'] == 2) {
            $BFP = 1.20 * $dailyCalories['body_mass_index'] + 0.23 * $request->customer_info['age'] - 5.4;
        }

        //Body Mass Index


        $bodyMassIndex       = $this->calculateBodyMassIndex($request->customer_info);
        $bodyMassIndexText   = $this->getBodyMassIndexText($bodyMassIndex);

        $proteinIntakeC = null;
        $carbsIntakeC   = null;
        $fatsIntakeC    = null;

        $proteinIntakeQ = null;
        $carbsIntakeQ   = null;
        $fatsIntakeQ    = null;

        if (isset($request->new_macronutrients_amount) != null) {
            if (isset($request->new_macronutrients_amount['answer']) != null) {
                if ($request->new_macronutrients_amount['answer'] == 1) {
                    $proteinIntake   = round($request->new_macronutrients_amount['protein_intake'] / 100, 2);
                    $carbsIntake     = round($request->new_macronutrients_amount['carbs_intake'] / 100, 2);
                    $fatsIntake      = round($request->new_macronutrients_amount['fats_intake'] / 100, 2);

                    $proteinIntakeC  =  round($proteinIntake * $dailyCaloriesResultCN, 2);
                    $proteinIntakeQ  =  round($proteinIntakeC / 4, 2);

                    $carbsIntakeC  =  round($carbsIntake * $dailyCaloriesResultCN, 2);
                    $carbsIntakeQ  =  round($carbsIntakeC / 4, 2);

                    $fatsIntakeC   =  round($fatsIntake * $dailyCaloriesResultCN, 2);
                    $fatsIntakeQ   =  round($fatsIntakeC / 9, 2);
                }
            }
        }

        $bodyFatPercentage = null;
        $fatMass = null;
        $leanMass = null;

        if (isset($request->body_fat_percentage_details) != null) {
            if (isset($request->body_fat_percentage_details['answer']) != null) {
                if ($request->body_fat_percentage_details['answer'] == 1) {
                    if ($request->customer_info['gender'] == 1) {
                        $bodyFatPercentage = (495 / (1.0324 - 0.19077 * log10($request->body_fat_percentage_details['waist_circumference'] - $request->body_fat_percentage_details['neck_circumference']) + 0.15456 * log10($request->customer_info['height'])) - 450);
                    } else {
                        $bodyFatPercentage = (495 / (1.29579 - 0.35004 * log10($request->body_fat_percentage_details['waist_circumference'] + $request->body_fat_percentage_details['hip_circumference'] - $request->body_fat_percentage_details['hip_circumference']) + 0.22100 * log10($request->customer_info['height'])) - 450);
                    }
                    $fatMass  = round(($bodyFatPercentage / 100) * $actualWeight, 2);
                    $leanMass = round(($actualWeight - $fatMass), 2);
                }
            }
        }


        return [
            "daily_calories" => [
                "your_daily_calories_for_your_goal_is"      => $dailyCaloriesResultCN,
                "min_daily_calories"                        => $minDailyCaloriesResultCN,
                "max_daily_calories"                        => $maxDailyCaloriesResultCN,
            ],

            "BMI" => [
                "body_mass_index"                           => $dailyCalories['body_mass_index'],
                'body_mass_index_text'                      => $bodyMassIndexText,
            ],

            "your_macronutrients_in_calories_are" => [
                "Protein"  => $proteinC,
                "Carbs"     => $carbsC,
                "Fats"     => $fatsC,
            ],

            "your_macronutrients_in_grams_are" => [
                "Protein"  => $protein,
                "Carbs"    => $carbsQ,
                "Fats"    => $fatsQ,
            ],

            "approximated_body_fat_percentage_based_on_BMI"  => round($BFP, 4),

            "new_macronutrients" => [
                "your_daily_calories_for_your_goal_is"      => $dailyCaloriesResultCN,
                "your_macronutrients_in_calories_are" => [
                    "Protein"  => $proteinIntakeC,
                    "Carbs"     => $carbsIntakeC,
                    "Fats"     => $fatsIntakeC,
                ],
                "your_macronutrients_in_grams_are" => [
                    "Protein"  => $proteinIntakeQ,
                    "Carbs"    => $carbsIntakeQ,
                    "Fats"    => $fatsIntakeQ,
                ],
            ],

            "body_fat_percentage_details_yes" => [
                "body_fat_percentage"  => round($bodyFatPercentage, 3),
                "fat_mass"             => $fatMass,
                "lean_mass"             => $leanMass,
            ],

            "body_fat_percentage_details_no" => [
                "body_fat_percentage"  => round($BFP, 5),
                "fat_mass"             => round(($BFP / 100) * $actualWeight, 2),
                "lean_mass"             => round($actualWeight - ($BFP / 100) * $actualWeight, 2),
            ],

            "Servings" => $this->servings($dailyCaloriesResultCN, $protein, $carbsQ, $fatsQ),
        ];
    }
























    private function minMaxServing()
    {
        return [
            "Starches" => [
                "min" => 3,
                "max" => 22
            ],
            "Fruits" => [
                "min" => 3,
                "max" => 12
            ],
            "Vegetables" => [
                "min" => 2,
                "max" => 13
            ],
            "Meats" => [
                "min" => 4,
                "max" => 11
            ],
            "Dairy" => [
                "min" => 2,
                "max" => 6
            ],
            "Oils" => [
                "min" => 3,
                "max" => 10
            ],
        ];
    }

    private function range2000()
    {
        return [
            "Starches" => [
                "min" => 4,
                "max" => 10,
            ],
            "Fruits" => [
                "min" => 1,
                "max" => 4
            ],
            "Vegetables" => [
                "min" => 2,
                "max" => 7
            ],
            "Meats" => [
                "min" => 4,
                "max" => 8
            ],
            "Dairy" => [
                "min" => 2,
                "max" => 3
            ],
            "Oils" => [
                "min" => 2,
                "max" => 5
            ],
        ];
    }

    private function range3000()
    {
        return [
            "Starches" => [
                "min" => 10,
                "max" => 16
            ],
            "Fruits" => [
                "min" => 4,
                "max" => 6
            ],
            "Vegetables" => [
                "min" => 4,
                "max" => 8
            ],
            "Meats" => [
                "min" => 8,
                "max" => 12
            ],
            "Dairy" => [
                "min" => 3,
                "max" => 4
            ],
            "Oils" => [
                "min" => 4,
                "max" => 8
            ],
        ];
    }

    private function range4000()
    {
        return [
            "Starches" => [
                "min" => 16,
                "max" => 20
            ],
            "Fruits" => [
                "min" => 6,
                "max" => 10
            ],
            "Vegetables" => [
                "min" => 8,
                "max" => 8
            ],
            "Meats" => [
                "min" => 12,
                "max" => 20
            ],
            "Dairy" => [
                "min" => 4,
                "max" => 6
            ],
            "Oils" => [
                "min" => 6,
                "max" => 10
            ],
        ];
    }

    private function constant()
    {
        return [
            "Starches" => [
                "Calories" => 80,
                "Carbs"    => 15,
                "Protein"  => 3,
                "Fats"     => 0,
            ],
            "Fruits" => [
                "Calories" => 60,
                "Carbs"    => 15,
                "Protein"  => 0,
                "Fats"     => 0,
            ],
            "Vegetables" => [
                "Calories" => 25,
                "Carbs"    => 5,
                "Protein"  => 2,
                "Fats"     => 0,
            ],
            "Meats" => [
                "Calories" => 75,
                "Carbs"    => 0,
                "Protein"  => 7,
                "Fats"     => 5,
            ],
            "Dairy" => [
                "Calories" => 120,
                "Carbs"    => 12,
                "Protein"  => 8,
                "Fats"     => 5,
            ],
            "Oils" => [
                "Calories" => 45,
                "Carbs"    => 0,
                "Protein"  => 0,
                "Fats"     => 5,
            ],
        ];
    }

    private function addStarchesToServing($result, $protein, $carbsQ, $starches)
    {
        $constant  = $this->constant();
        if (
            $constant["Starches"]["Protein"] + $result['total_protein'] < $protein
            && $constant["Starches"]["Carbs"] + $result['total_carbs'] < $carbsQ
        ) {
            $result['total_protein']  += $constant["Starches"]["Protein"];
            $result['total_carbs']    += $constant["Starches"]["Carbs"];
            $result['total_calories'] += $constant["Starches"]["Calories"];
            $starches++;
        }
        return $starches;
    }
    private function addFruitsToServing($result, $carbsQ, $fruits)
    {
        $constant  = $this->constant();
        if ($constant["Fruits"]["Carbs"] + $result['total_carbs'] < $carbsQ) {
            $result['total_carbs']    += $constant["Fruits"]["Carbs"];
            $result['total_calories'] += $constant["Fruits"]["Calories"];
            $fruits++;
        }
        return $fruits;
    }
    private function addVegetablesToServing($result, $carbsQ, $vegetables, $protein)
    {
        $constant  = $this->constant();
        if (
            $constant["Vegetables"]["Protein"] + $result['total_protein'] < $protein
            && $constant["Vegetables"]["Carbs"] + $result['total_carbs'] < $carbsQ
        ) {
            $result['total_protein']    += $constant["Vegetables"]["Protein"];
            $result['total_carbs'] += $constant["Vegetables"]["Carbs"];
            $result['total_calories'] += $constant["Vegetables"]["Calories"];
            $vegetables++;
        }
        return $vegetables;
    }
    private function addMeatsToServing($result, $protein, $fatsQ, $meats)
    {
        $constant  = $this->constant();
        if (
            $constant["Meats"]["Protein"] + $result['total_protein'] < $protein
            && $constant["Meats"]["Fats"] + $result['total_fats'] < $fatsQ
        ) {
            $result['total_protein']    += $constant["Meats"]["Protein"];
            $result['total_fats'] += $constant["Meats"]["Fats"];
            $result['total_calories'] += $constant["Meats"]["Calories"];
            $meats++;
        }
        return $meats;
    }
    private function addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ)
    {
        $constant  = $this->constant();

        if (
            $constant["Dairy"]["Protein"] + $result['total_protein'] < $protein &&
            $constant["Dairy"]["Carbs"] + $result['total_carbs'] < $carbsQ &&
            $constant["Dairy"]["Fats"] + $result['total_fats'] < $fatsQ
        ) {
            $result['total_protein']    += $constant["Dairy"]["Protein"];
            $result['total_carbs']    += $constant["Dairy"]["Carbs"];

            $result['total_fats'] += $constant["Dairy"]["Fats"];
            $result['total_calories'] += $constant["Dairy"]["Calories"];
            $dairy++;
        }
        return $dairy;
    }
    private function addOilsToServing($result, $fatsQ, $oils)
    {
        $constant  = $this->constant();

        if ($constant["Oils"]["Fats"] + $result['total_fats'] < $fatsQ) {
            $result['total_fats']     += $constant["Oils"]["Fats"];
            $result['total_calories'] += $constant["Oils"]["Calories"];
            $oils++;
        }
        return $oils;
    }

    private function servings($dailyCaloriesResultCN, $protein, $carbsQ, $fatsQ)
    {
        $range2000 = $this->range2000();
        $range3000 = $this->range3000();
        $range4000 = $this->range4000();
        $constant  = $this->constant();


        $result = [
            "total_calories"  => 0,
            "total_protein"   => 0,
            "total_carbs"     => 0,
            "total_fats"      => 0,
        ];

        if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
            $starches    = $range2000['Starches']['min'];
            $fruits      = $range2000['Fruits']['min'];
            $vegetables  = $range2000['Vegetables']['min'];
            $meats       = $range2000['Meats']['min'];
            $dairy       = $range2000['Dairy']['min'];
            $oils        = $range2000['Oils']['min'];

            $result['total_calories'] = ($constant['Starches']['Calories']) * $starches;
            $result['total_protein']  = ($constant['Starches']['Protein']) * $starches;
            $result['total_carbs']    = ($constant['Starches']['Carbs']) * $starches;
            $result['total_fats']     = ($constant['Starches']['Fats']) * $starches;

            $result['total_calories'] = ($constant['Fruits']['Calories']) * $fruits;
            $result['total_protein']  = ($constant['Fruits']['Protein']) * $fruits;
            $result['total_carbs']    = ($constant['Fruits']['Carbs']) * $fruits;
            $result['total_fats']     = ($constant['Fruits']['Fats']) * $fruits;

            $result['total_calories'] = ($constant['Vegetables']['Calories']) * $vegetables;
            $result['total_protein']  = ($constant['Vegetables']['Protein']) * $vegetables;
            $result['total_carbs']    = ($constant['Vegetables']['Carbs']) * $vegetables;
            $result['total_fats']     = ($constant['Vegetables']['Fats']) * $vegetables;

            $result['total_calories'] = ($constant['Meats']['Calories']) * $meats;
            $result['total_protein']  = ($constant['Meats']['Protein']) * $meats;
            $result['total_carbs']    = ($constant['Meats']['Carbs']) * $meats;
            $result['total_fats']     = ($constant['Meats']['Fats']) * $meats;

            $result['total_calories'] = ($constant['Dairy']['Calories']) * $dairy;
            $result['total_protein']  = ($constant['Dairy']['Protein']) * $dairy;
            $result['total_carbs']    = ($constant['Dairy']['Carbs']) * $dairy;
            $result['total_fats']     = ($constant['Dairy']['Fats']) * $dairy;

            $result['total_calories'] = ($constant['Oils']['Calories']) * $oils;
            $result['total_protein']  = ($constant['Oils']['Protein']) * $oils;
            $result['total_carbs']    = ($constant['Oils']['Carbs']) * $oils;
            $result['total_fats']     = ($constant['Oils']['Fats']) * $oils;
        }

        if ($dailyCaloriesResultCN >= 2000 && $dailyCaloriesResultCN <= 3000) {
            $starches    = $range3000['Starches']['min'];
            $fruits      = $range3000['Fruits']['min'];
            $vegetables  = $range3000['Vegetables']['min'];
            $meats       = $range3000['Meats']['min'];
            $dairy       = $range3000['Dairy']['min'];
            $oils        = $range3000['Oils']['min'];

            $result['total_calories'] += ($constant['Starches']['Calories']) * $starches;
            $result['total_protein']  += ($constant['Starches']['Protein']) * $starches;
            $result['total_carbs']    += ($constant['Starches']['Carbs']) * $starches;
            $result['total_fats']     += ($constant['Starches']['Fats']) * $starches;

            $result['total_calories'] += ($constant['Fruits']['Calories']) * $fruits;
            $result['total_protein']  += ($constant['Fruits']['Protein']) * $fruits;
            $result['total_carbs']    += ($constant['Fruits']['Carbs']) * $fruits;
            $result['total_fats']     += ($constant['Fruits']['Fats']) * $fruits;

            $result['total_calories'] += ($constant['Vegetables']['Calories']) * $vegetables;
            $result['total_protein']  += ($constant['Vegetables']['Protein']) * $vegetables;
            $result['total_carbs']    += ($constant['Vegetables']['Carbs']) * $vegetables;
            $result['total_fats']     += ($constant['Vegetables']['Fats']) * $vegetables;

            $result['total_calories'] += ($constant['Meats']['Calories']) * $meats;
            $result['total_protein']  += ($constant['Meats']['Protein']) * $meats;
            $result['total_carbs']    += ($constant['Meats']['Carbs']) * $meats;
            $result['total_fats']     += ($constant['Meats']['Fats']) * $meats;

            $result['total_calories'] += ($constant['Dairy']['Calories']) * $dairy;
            $result['total_protein']  += ($constant['Dairy']['Protein']) * $dairy;
            $result['total_carbs']    += ($constant['Dairy']['Carbs']) * $dairy;
            $result['total_fats']     += ($constant['Dairy']['Fats']) * $dairy;

            $result['total_calories'] += ($constant['Oils']['Calories']) * $oils;
            $result['total_protein']  += ($constant['Oils']['Protein']) * $oils;
            $result['total_carbs']    += ($constant['Oils']['Carbs']) * $oils;
            $result['total_fats']     += ($constant['Oils']['Fats']) * $oils;
        }

        if ($dailyCaloriesResultCN >= 3000 && $dailyCaloriesResultCN <= 4000) {
            $starches    = $range4000['Starches']['min'];
            $fruits      = $range4000['Fruits']['min'];
            $vegetables  = $range4000['Vegetables']['min'];
            $meats       = $range4000['Meats']['min'];
            $dairy       = $range4000['Dairy']['min'];
            $oils        = $range4000['Oils']['min'];

            $result['total_calories'] += ($constant['Starches']['Calories']) * $starches;
            $result['total_protein']  += ($constant['Starches']['Protein']) * $starches;
            $result['total_carbs']    += ($constant['Starches']['Carbs']) * $starches;
            $result['total_fats']     += ($constant['Starches']['Fats']) * $starches;

            $result['total_calories'] += ($constant['Fruits']['Calories']) * $fruits;
            $result['total_protein']  += ($constant['Fruits']['Protein']) * $fruits;
            $result['total_carbs']    += ($constant['Fruits']['Carbs']) * $fruits;
            $result['total_fats']     += ($constant['Fruits']['Fats']) * $fruits;

            $result['total_calories'] += ($constant['Vegetables']['Calories']) * $vegetables;
            $result['total_protein']  += ($constant['Vegetables']['Protein']) * $vegetables;
            $result['total_carbs']    += ($constant['Vegetables']['Carbs']) * $vegetables;
            $result['total_fats']     += ($constant['Vegetables']['Fats']) * $vegetables;

            $result['total_calories'] += ($constant['Meats']['Calories']) * $meats;
            $result['total_protein']  += ($constant['Meats']['Protein']) * $meats;
            $result['total_carbs']    += ($constant['Meats']['Carbs']) * $meats;
            $result['total_fats']     += ($constant['Meats']['Fats']) * $meats;

            $result['total_calories'] += ($constant['Dairy']['Calories']) * $dairy;
            $result['total_protein']  += ($constant['Dairy']['Protein']) * $dairy;
            $result['total_carbs']    += ($constant['Dairy']['Carbs']) * $dairy;
            $result['total_fats']     += ($constant['Dairy']['Fats']) * $dairy;

            $result['total_calories'] += ($constant['Oils']['Calories']) * $oils;
            $result['total_protein']  += ($constant['Oils']['Protein']) * $oils;
            $result['total_carbs']    += ($constant['Oils']['Carbs']) * $oils;
            $result['total_fats']     += ($constant['Oils']['Fats']) * $oils;
        }

        for ($x = 250; $x > 0; $x--) {
            if ($dailyCaloriesResultCN > $result['total_calories']) {

                $priority = [
                    "Starches"      => rand(4, 6),
                    "Fruits"        => rand(1, 3),
                    "Vegetables"    => rand(1, 3),
                    "Meats"         => rand(4, 6),
                    "Dairy"         => rand(1, 3),
                    "Oils"          => rand(1, 3),
                ];

                foreach ($priority as $key => $value) {
                    if ($value == 6) {
                        if ($key == "Starches") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($starches <= $range2000['Starches']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($starches <= $range3000['Starches']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($starches <= $range4000['Starches']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                        }

                        if ($key == "Fruits") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($fruits <= $range2000['Fruits']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($fruits <= $range3000['Fruits']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($fruits <= $range4000['Fruits']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                        }

                        if ($key == "Vegetables") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($vegetables <= $range2000['Vegetables']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($fruits <= $range3000['Vegetables']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($fruits <= $range4000['Vegetables']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                        }

                        if ($key == "Meats") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($meats <= $range2000['Meats']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($meats <= $range3000['Meats']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($meats <= $range4000['Meats']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                        }

                        if ($key == "Dairy") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($dairy <= $range2000['Dairy']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($dairy <= $range3000['Dairy']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($dairy <= $range4000['Dairy']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                        }

                        if ($key == "Oils") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($oils <= $range2000['Oils']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($oils <= $range3000['Oils']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($oils <= $range4000['Oils']['max']) {
                                    for ($i = 0; $i < 6; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                        }
                    }

                    if ($value == 5) {
                        if ($key == "Starches") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($starches <= $range2000['Starches']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($starches <= $range3000['Starches']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($starches <= $range4000['Starches']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                        }

                        if ($key == "Fruits") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($fruits <= $range2000['Fruits']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($fruits <= $range3000['Fruits']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($fruits <= $range4000['Fruits']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                        }

                        if ($key == "Vegetables") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($vegetables <= $range2000['Vegetables']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($fruits <= $range3000['Vegetables']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($fruits <= $range4000['Vegetables']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                        }

                        if ($key == "Meats") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($meats <= $range2000['Meats']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($meats <= $range3000['Meats']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($meats <= $range4000['Meats']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                        }

                        if ($key == "Dairy") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($dairy <= $range2000['Dairy']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($dairy <= $range3000['Dairy']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($dairy <= $range4000['Dairy']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                        }

                        if ($key == "Oils") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($oils <= $range2000['Oils']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($oils <= $range3000['Oils']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($oils <= $range4000['Oils']['max']) {
                                    for ($i = 0; $i < 5; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                        }
                    }

                    if ($value == 4) {
                        if ($key == "Starches") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($starches <= $range2000['Starches']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($starches <= $range3000['Starches']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($starches <= $range4000['Starches']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                        }

                        if ($key == "Fruits") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($fruits <= $range2000['Fruits']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($fruits <= $range3000['Fruits']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($fruits <= $range4000['Fruits']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                        }

                        if ($key == "Vegetables") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($vegetables <= $range2000['Vegetables']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($fruits <= $range3000['Vegetables']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($fruits <= $range4000['Vegetables']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                        }

                        if ($key == "Meats") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($meats <= $range2000['Meats']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($meats <= $range3000['Meats']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($meats <= $range4000['Meats']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                        }

                        if ($key == "Dairy") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($dairy <= $range2000['Dairy']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($dairy <= $range3000['Dairy']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($dairy <= $range4000['Dairy']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                        }

                        if ($key == "Oils") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($oils <= $range2000['Oils']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($oils <= $range3000['Oils']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($oils <= $range4000['Oils']['max']) {
                                    for ($i = 0; $i < 4; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                        }
                    }

                    if ($value == 3) {
                        if ($key == "Starches") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($starches <= $range2000['Starches']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($starches <= $range3000['Starches']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($starches <= $range4000['Starches']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                        }

                        if ($key == "Fruits") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($fruits <= $range2000['Fruits']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($fruits <= $range3000['Fruits']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($fruits <= $range4000['Fruits']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                        }

                        if ($key == "Vegetables") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($vegetables <= $range2000['Vegetables']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($fruits <= $range3000['Vegetables']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($fruits <= $range4000['Vegetables']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                        }

                        if ($key == "Meats") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($meats <= $range2000['Meats']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($meats <= $range3000['Meats']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($meats <= $range4000['Meats']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                        }

                        if ($key == "Dairy") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($dairy <= $range2000['Dairy']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($dairy <= $range3000['Dairy']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($dairy <= $range4000['Dairy']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                        }

                        if ($key == "Oils") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($oils <= $range2000['Oils']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($oils <= $range3000['Oils']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($oils <= $range4000['Oils']['max']) {
                                    for ($i = 0; $i < 3; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                        }
                    }

                    if ($value == 2) {
                        if ($key == "Starches") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($starches <= $range2000['Starches']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($starches <= $range3000['Starches']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($starches <= $range4000['Starches']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                    }
                                }
                            }
                        }

                        if ($key == "Fruits") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($fruits <= $range2000['Fruits']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($fruits <= $range3000['Fruits']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($fruits <= $range4000['Fruits']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                    }
                                }
                            }
                        }

                        if ($key == "Vegetables") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($vegetables <= $range2000['Vegetables']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($fruits <= $range3000['Vegetables']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($fruits <= $range4000['Vegetables']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                    }
                                }
                            }
                        }

                        if ($key == "Meats") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($meats <= $range2000['Meats']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($meats <= $range3000['Meats']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($meats <= $range4000['Meats']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                    }
                                }
                            }
                        }

                        if ($key == "Dairy") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($dairy <= $range2000['Dairy']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($dairy <= $range3000['Dairy']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($dairy <= $range4000['Dairy']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                    }
                                }
                            }
                        }

                        if ($key == "Oils") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($oils <= $range2000['Oils']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($oils <= $range3000['Oils']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($oils <= $range4000['Oils']['max']) {
                                    for ($i = 0; $i < 2; $i++) {
                                        $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                    }
                                }
                            }
                        }
                    }

                    if ($value == 1) {
                        if ($key == "Starches") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($starches <= $range2000['Starches']['max']) {
                                    $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($starches <= $range3000['Starches']['max']) {
                                    $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($starches <= $range4000['Starches']['max']) {
                                    $finalStarches = $this->addStarchesToServing($result, $protein, $carbsQ, $starches);
                                }
                            }
                        }

                        if ($key == "Fruits") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($fruits <= $range2000['Fruits']['max']) {
                                    $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($fruits <= $range3000['Fruits']['max']) {
                                    $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($fruits <= $range4000['Fruits']['max']) {
                                    $finalFruits = $this->addFruitsToServing($result, $carbsQ, $fruits);
                                }
                            }
                        }

                        if ($key == "Vegetables") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($vegetables <= $range2000['Vegetables']['max']) {
                                    $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($fruits <= $range3000['Vegetables']['max']) {
                                    $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($fruits <= $range4000['Vegetables']['max']) {
                                    $finalVegetables = $this->addVegetablesToServing($result, $carbsQ, $vegetables, $protein);
                                }
                            }
                        }

                        if ($key == "Meats") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($meats <= $range2000['Meats']['max']) {
                                    $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($meats <= $range3000['Meats']['max']) {
                                    $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($meats <= $range4000['Meats']['max']) {
                                    $finalMeats = $this->addMeatsToServing($result, $protein, $fatsQ, $meats);
                                }
                            }
                        }

                        if ($key == "Dairy") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($dairy <= $range2000['Dairy']['max']) {
                                    $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($dairy <= $range3000['Dairy']['max']) {
                                    $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($dairy <= $range4000['Dairy']['max']) {
                                    $finalDairy = $this->addDairyToServing($result, $protein, $fatsQ, $dairy, $carbsQ);
                                }
                            }
                        }

                        if ($key == "Oils") {
                            if ($dailyCaloriesResultCN >= 1200 && $dailyCaloriesResultCN <= 2000) {
                                if ($oils <= $range2000['Oils']['max']) {
                                    $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                }
                            }
                            if ($dailyCaloriesResultCN > 2000 && $dailyCaloriesResultCN <= 3000) {
                                if ($oils <= $range3000['Oils']['max']) {
                                    $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                }
                            }
                            if ($dailyCaloriesResultCN > 3000 && $dailyCaloriesResultCN <= 4000) {
                                if ($oils <= $range4000['Oils']['max']) {
                                    $finalOils = $this->addOilsToServing($result, $fatsQ, $oils);
                                }
                            }
                        }
                    }
                }
            }
        }

        return [
            'starches'    => $starches,
            'fruits'      => $fruits,
            'vegetables'  => $vegetables,
            'meats'       => $meats,
            'dairy'       => $dairy,
            'oils'        => $oils,
            'total_calories'  => $result['total_calories'],
            'total_protein'   => $result['total_protein'],
            'total_carbs'     => $result['total_carbs'],
            'total_fats'      => $result['total_fats'],
            "result"          => [
                'starches'    => $finalStarches ?? 0,
                'fruits'      => $finalFruits ?? 0,
                'vegetables'  => $finalVegetables ?? 0,
                'meats'       => $finalMeats ?? 0,
                'dairy'       => $finalDairy ?? 0,
                'oils'        => $finalOils ?? 0,
            ]
        ];
    }
}
