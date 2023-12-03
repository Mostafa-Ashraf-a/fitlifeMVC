<?php

use App\Http\Controllers\API\AuthCustomerController;
use App\Http\Controllers\API\BodyPartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CategoryTypeController;
use App\Http\Controllers\API\EquipmentController;
use App\Http\Controllers\API\ExerciseController;
use App\Http\Controllers\API\ExerciseTypeController;
use App\Http\Controllers\API\GuestUserController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\QuestionnaireController;
use App\Http\Controllers\API\FAQController;
use App\Http\Controllers\API\SettingController;
use App\Http\Controllers\API\SleepTrackerController;
use App\Http\Controllers\API\User\Exercise\Program\SuggestionController;
use App\Http\Controllers\API\User\Nutrition\FoodExchangeController;
use App\Http\Controllers\API\User\Nutrition\FoodTypeController;
use App\Http\Controllers\API\User\Nutrition\RecipeController;
use App\Http\Controllers\API\User\Subscription\InvoiceController;
use App\Http\Controllers\API\UserExercisePlanController;
use App\Http\Controllers\API\WaterTrackerController;
use App\Http\Controllers\API\WeightTrackerController;
use App\Http\Controllers\SMS\SMSController;
use Illuminate\Support\Facades\Route;


Route::apiResource('plans', \App\Http\Controllers\API\PlanController::class)->only(['index']);
Route::apiResource('subscriptions', \App\Http\Controllers\API\SubscriptionController::class)->only(['index', 'store']);

Route::group(['prefix' => 'v1', 'middleware' => ['jsonResponse', 'cors']], function () {

    Route::post('send-sms-code', [SMSController::class, 'send']);
    Route::post('register', [GuestUserController::class, 'register']);
    Route::post('verify', [GuestUserController::class, 'verify']);
    Route::post('re-send-otpCode', [GuestUserController::class, 'reSendOtpCode']);
    Route::post('reset-password', [GuestUserController::class, 'resetPassword']);
    Route::post('customer-login', [GuestUserController::class, 'customerLogin']);

    Route::group(['prefix' => 'customer', 'middleware' => ['auth:user-api']], function () {
        Route::get('test',function (){
        });
        Route::post('change-profile-picture', [\App\Http\Controllers\API\UserController::class, 'changeProfilePicture']);
        Route::post('change-profile-info', [\App\Http\Controllers\API\UserController::class, 'update']);

        Route::get('profile', [\App\Http\Controllers\API\UserController::class, 'profile']);

        Route::post('change-password', [\App\Http\Controllers\API\UserController::class, 'changePassword']);

        Route::post('account/deactivate', [\App\Http\Controllers\API\UserController::class, 'deactivateAccount']);

        Route::apiResource('categories', CategoryController::class)->only('show');
        Route::apiResource('category-types', CategoryTypeController::class)->only('index');
        Route::apiResource('posts', PostController::class)->only(['index']);

        // settings
        Route::apiResource('faqs', FAQController::class)->only('index');
        // logout
        Route::get('logout', [AuthCustomerController::class, 'customerLogout']);
        // Questionnaire
        Route::get('questionnaires', [QuestionnaireController::class, 'getAllQuestionnaire'])->withoutMiddleware('auth:user-api');
        Route::post('questionnaires/calculation', [QuestionnaireController::class, 'questionnaireCalculation']);

        Route::post('rm-calculator', [QuestionnaireController::class, 'rmCalculator']);
        Route::get('rm-calculator', [QuestionnaireController::class, 'getRmCalculator']);

        Route::get('exercise-types', [ExerciseTypeController::class, 'index']);

        Route::get('body-parts', [BodyPartController::class, 'index']);
        Route::get('equipments', [EquipmentController::class, 'index']);
        Route::apiResource('exercises', ExerciseController::class)->only(['index', 'show']);
        Route::apiResource('settings', SettingController::class)->only(['index', 'show']);

        // Weight Tracker
        Route::post('tracker-weight', [WeightTrackerController::class, 'addNewWeight']);
        Route::get('tracker-last-weight', [WeightTrackerController::class, 'getLastWeight']);
        Route::get('tracker-weight-statistics', [WeightTrackerController::class, 'getWeightStatistics']);
        Route::get('tracker-weight-filter', [WeightTrackerController::class, 'index']);

        // Water Tracker
        Route::post('tracker-water', [WaterTrackerController::class, 'store']);
        Route::post('water-intake', [WaterTrackerController::class, 'calculateWaterIntake']);
        Route::get('tracker-water', [WaterTrackerController::class, 'show']);
        Route::get('tracker-water-filter', [WaterTrackerController::class, 'index']);

        // Sleep Tracker
        Route::post('tracker-sleep', [SleepTrackerController::class, 'store']);
        Route::get('tracker-sleep', [SleepTrackerController::class, 'show']);
        Route::get('tracker-sleep-filter', [SleepTrackerController::class, 'index']);

        Route::apiResource('challenges', \App\Http\Controllers\API\ChallengeController::class)->only(['index', 'show']);


        //Suggested Exercise Program
        Route::apiResource('user-exercise-plan', UserExercisePlanController::class);
        Route::apiResource('exercise-plan/setting', \App\Http\Controllers\API\User\Exercise\Plan\SettingController::class)->only(['index', 'store']);
        Route::apiResource('calculation-result', \App\Http\Controllers\API\UserCalculationController::class)->only(['index', 'show']);


        Route::apiResource('plans', \App\Http\Controllers\API\PlanController::class)->only(['index']);
        Route::apiResource('subscriptions', \App\Http\Controllers\API\SubscriptionController::class)->only(['index', 'store']);
        Route::apiResource('invoice', InvoiceController::class)->only(['store']);
    });
});

Route::group(['prefix' => 'v1/customer', 'middleware' => ['jsonResponse', 'cors', 'auth:user-api']], function () {

    Route::group(['prefix' => 'exercise'], function () {
        Route::apiResource('/program-suggestions', SuggestionController::class)->only(['index', 'store', 'show']);
    });

    Route::group(['prefix' => 'nutrition'], function () {

        Route::apiResource('/food-types', FoodTypeController::class)->only('index'); // Get all food types
        Route::apiResource('/food-exchanges', FoodExchangeController::class)->only(['index']); // Get all food exchanges

        Route::apiResource('/plans', \App\Http\Controllers\API\User\Nutrition\PlanController::class)->only(['index', 'store', 'update']);
        Route::apiResource('/meals', \App\Http\Controllers\API\User\Nutrition\MealController::class); // Get Store Update Delete
        Route::apiResource('/serving', \App\Http\Controllers\API\User\Nutrition\ServingController::class)->only(['index', 'update', 'suggestedServing']);
        Route::apiResource('/tips', \App\Http\Controllers\API\User\Nutrition\TipController::class)->only('index');
        Route::apiResource('/history-plans', \App\Http\Controllers\API\User\Nutrition\HistoryPlanController::class)->only('index', 'show', 'store', 'update');

        Route::get('recipes/shuffle/{meal_type_id}', [RecipeController::class, 'shuffle']);
        Route::apiResource('/recipes', RecipeController::class)->only('show');

        Route::group(['prefix' => 'suggested'], function () {
            Route::apiResource('/plans', \App\Http\Controllers\API\User\Nutrition\SuggestedMealPlan\PlanController::class)->only(['index', 'store', 'update']);
            Route::apiResource('/running/plans', \App\Http\Controllers\API\User\Nutrition\SuggestedMealPlan\RunningPlanController::class)->only(['index', 'show', 'update']);
            Route::get('/weekly/plans', [\App\Http\Controllers\API\User\Nutrition\SuggestedMealPlan\RunningPlanController::class, 'listWeeklyPlans']);
            Route::put('/serving/{serving_id}', [\App\Http\Controllers\API\User\Nutrition\ServingController::class, 'suggestedServing']);
        });
    });
});


Route::any('{any}', function () {
    return response()->json([
        'code'      => 404,
        'error'     => true,
        'message'   => "Resource Not Found",
        'payload'   => null
    ], 404);
})->where('any', '.*')->name('api.fallback');
