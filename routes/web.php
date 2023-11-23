<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BodyPartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChallengeController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\ExerciseController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\GoalController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\Marketing\CouponController;
use App\Http\Controllers\Admin\Nutrition\MealController;
use App\Http\Controllers\Admin\Nutrition\MealTypeController;
use App\Http\Controllers\Admin\Nutrition\MeasurementUnitController;
use App\Http\Controllers\Admin\Nutrition\FoodExchangeController;
use App\Http\Controllers\Admin\Nutrition\FoodTypeController;
use App\Http\Controllers\Admin\Nutrition\MealPlanController;
use App\Http\Controllers\Admin\Nutrition\RecipeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProgramTypeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\WorkoutController;
use App\Models\FoodExchange;
use App\Models\FoodExchangeTranslation;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::view('/login', 'admin.login')->name('login');


Route::get('/', function () {
    return view('web.index_ar');
})->name('web.index');


Route::get('/indexen', function () {
    return view('web.index');
})->name('web.indexen');


Route::get('/privacy', function () {
    return view('web.privacy');
})->name('web.privacy');

Route::get('/resources', function () {
    return view('web.resources');
})->name('web.resources');

Route::post('/contact-us', function () {
    return redirect()->back()->with('success', 'Your message has been sent successfully.');
})->name('web.contact-us');

Route::prefix('manager')->name('manager.')->group(function () {


    Route::middleware(['guest:manager', 'PreventBackHistory'])->group(function () {
        Route::view('/login', 'admin.login')->name('login');
        Route::post('/check', [AdminController::class, 'check'])->name('check');
    });


    Route::middleware(['auth:manager', 'PreventBackHistory'])->group(function () {
        Route::prefix('/profile')->group(function () {
            Route::get('/view', [AdminController::class, 'viewProfile']);
            Route::put('/view', [AdminController::class, 'updateProfile']);
            Route::get('/change-password', [AdminController::class, 'viewChangePassword']);
            Route::post('/change-password', [AdminController::class, 'changePassword']);
        });

        Route::prefix('/nutrition')->group(function () {
            Route::resource('/meal-types', MealTypeController::class);
            Route::resource('/recipes', RecipeController::class);
            Route::get('meals/{meal_type_id}/list', [MealController::class, 'listMeals']);
            Route::resource('/meals', MealController::class);

            Route::delete('/food-exchanges/measurement-unit/{measurement_id}/{food_exchange_id}', [FoodExchangeController::class, 'deleteMeasurementUnit']);
            Route::get('food-exchanges/index', [FoodExchangeController::class, 'dataTable']);
            Route::resource('/food-exchanges', FoodExchangeController::class);

            Route::resource('/food-types', FoodTypeController::class)->only(['index', 'edit', 'update']);

            // User Meal Plan & Suggested Meal Plan Will be saved in the plans table
            Route::delete('/meal-plans/{mealTypeId}/{mealId}/{mealPlanId}', [MealPlanController::class, 'deleteMealTypeMeal']);
            Route::resource('/meal-plans', MealPlanController::class);

            Route::resource('/measurement-units', MeasurementUnitController::class);
        });

        Route::prefix('/exercise')->group(function () {
            Route::resource('goals', GoalController::class)->only('index')->only('index', 'edit', 'update');
            Route::resource('levels', LevelController::class)->only('index', 'edit', 'update');
        });

        Route::prefix('/marketing')->group(function () {
            Route::put('/coupons/{coupon_id}/change-status', [CouponController::class, 'changeStatus']);
            Route::resource('/coupons', CouponController::class)->except(['show']);
        });

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::post('/users/change-status', [\App\Http\Controllers\Admin\UserController::class, 'changeStatus']);
        Route::resource('/users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'store', 'create']);

        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::post('/upload', [AdminController::class, 'uploadFile']);


        Route::get('exercises/index', [ExerciseController::class, 'dataTable']);
        Route::resource('exercises', ExerciseController::class);

        Route::resource('equipments', EquipmentController::class);

        Route::resource('body-parts', BodyPartController::class)->only('index', 'edit', 'update');

        Route::resource('/categories', CategoryController::class);

        Route::resource('/tags', TagController::class);

        Route::get('posts/index', [PostController::class, 'dataTable']);
        Route::get('/posts/get-categories', [PostController::class, 'getCategories']);
        Route::resource('/posts', PostController::class);

        Route::resource('tips', \App\Http\Controllers\Admin\Nutrition\TipController::class);

        Route::resource('/settings', SettingController::class);

        Route::resource('faqs', FAQController::class)->except('show');

        Route::get('/workouts/get-exercise-types', [WorkoutController::class, 'getExerciseTypes']);
        Route::post('/workouts/get-exercises', [WorkoutController::class, 'getExercise']);
        Route::resource('/workouts', WorkoutController::class);
        Route::get('/workouts/{id}/setup', [WorkoutController::class, 'setup']);

        Route::resource('challenges', ChallengeController::class);

        Route::resource('plan-durations', \App\Http\Controllers\Admin\PlanDurationController::class)->only(['index']);
        Route::post('/plan-durations/change-status', [\App\Http\Controllers\Admin\PlanDurationController::class, 'changeStatus']);

        Route::post('/plan-managements/change-status', [\App\Http\Controllers\Admin\PlanManagementController::class, 'changeStatus']);
        Route::resource('plan-managements', \App\Http\Controllers\Admin\PlanManagementController::class);

        Route::resource('subscriptions', SubscriptionController::class)->only(['index']);

        Route::resource('program-types', ProgramTypeController::class)->only(['index', 'show', 'update']);
    });
});

Route::get('testing', function (Request $request) {
    $foods = FoodExchange::all();
    $foods_translations = FoodExchangeTranslation::all();

    return view('web.testing', compact('foods', 'foods_translations'));
});
