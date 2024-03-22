<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SettingSeerder::class);
        $this->call(CategoryTypeSeeder::class);
        $this->call(ExerciseTypeSeeder::class);
        $this->call(GoalTypeSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(AnswerSeeder::class);
        $this->call(FoodTypeSeeder::class);
        $this->call(MeasurementUnitSeeder::class);
        $this->call(BodyPartSeeder::class);
        $this->call(WorkoutTypeSeeder::class);
        $this->call(PlanDurationSeeder::class);
        $this->call(EquipmentSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(ExerciseSeeder::class);
        $this->call(DaySeeder::class);
        $this->call(GoalSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(FoodExchangeSeeder::class);
        $this->call(MealSeeder::class);
        $this->call(UserServingSeeder::class);
        $this->call(FoodExchangeMeasurementSeeder::class);
        $this->call(PlanManagementSeeder::class);
        $this->call(MealTypeSeeder::class);
        $this->call(WorkoutsSeeder::class);
    }
}
