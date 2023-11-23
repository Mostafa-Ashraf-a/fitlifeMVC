<?php

namespace Database\Seeders;

use App\Models\PlanDuration;
use Illuminate\Database\Seeder;

class PlanDurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'id'    => 1,
                'ar' => [
                    'duration_name'   => "مجانية",
                ],
                'en' => [
                    'duration_name'   => "Free"
                ],

            ],[
                'id'    => 2,
                'ar' => [
                    'duration_name'   => "أسبوعياً",
                ],
                'en' => [
                    'duration_name'   => "Weekly"
                ],

            ],[
                'id'    => 3,
                'ar' => [
                    'duration_name'   => "شهرياً",
                ],
                'en' => [
                    'duration_name'   => "Monthly"
                ],
            ],[
                'id'    => 4,
                'ar' => [
                    'duration_name'   => "سنوياً",
                ],
                'en' => [
                    'duration_name'   => "Yearly"
                ],
            ],[
                'id'    => 5,
                'ar' => [
                    'duration_name'   => "ربع سنوية",
                ],
                'en' => [
                    'duration_name'   => "Quarterly"
                ],
            ],[
                'id'    => 6,
                'ar' => [
                    'duration_name'   => "نصف سنوية",
                ],
                'en' => [
                    'duration_name'   => "semi-annual"
                ],
            ],
        ];
        foreach($plans as $plan){
            PlanDuration::create($plan);
        }
    }
}
