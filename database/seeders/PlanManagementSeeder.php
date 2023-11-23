<?php

namespace Database\Seeders;

use App\Models\PlanManagement;
use Illuminate\Database\Seeder;

class PlanManagementSeeder extends Seeder
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
                    'plan_name'     => "مجانية",
                    'description'   => "مجانية",
                    'features'      => "مجانية",
                ],
                'en' => [
                    'plan_name'     => "Free",
                    'description'   => "Free",
                    'features'      => "Free",
                ],
                'plan_duration_id'  => 1,
                'trail_period'      => 0,
                'price'             => null,

            ],[
                'id'    => 2,
                'ar' => [
                    'plan_name'     => "أسبوعياً",
                    'description'   => "أسبوعياً",
                    'features'      => "أسبوعياً",
                ],
                'en' => [
                    'plan_name'     => "Weekly",
                    'description'   => "Weekly",
                    'features'      => "Weekly",
                ],
                'plan_duration_id'  => 2,
                'trail_period'      => 0,
                'price'             => 20,

            ],[
                'id'    => 3,
                'ar' => [
                    'plan_name'     => "شهرياً",
                    'description'   => "أسبوعياً",
                    'features'      => "أسبوعياً",
                ],
                'en' => [
                    'plan_name'     => "Monthly",
                    'description'   => "Monthly",
                    'features'      => "Monthly",
                ],
                'plan_duration_id'  => 3,
                'trail_period'      => 5,
                'price'             => 30,
            ],[
                'id'    => 4,
                'ar' => [
                    'plan_name'     => "سنوياً",
                    'description'   => "سنويا",
                    'features'      => "سنويا",
                ],
                'en' => [
                    'plan_name'     => "Yearly",
                    'description'   => "Yearly",
                    'features'      => "Yearly",
                ],
                'plan_duration_id'  => 4,
                'trail_period'      => 0,
                'price'             => 100,
            ],[
                'id'    => 5,
                'ar' => [
                    'plan_name'     => "ربع سنوية",
                    'description'   => "ربع سنوية",
                    'features'      => "ربع سنوية",
                ],
                'en' => [
                    'plan_name'     => "Quarterly",
                    'description'   => "Quarterly",
                    'features'      => "Quarterly",
                ],
                'plan_duration_id'  => 5,
                'trail_period'      => 13,
                'price'             => 250,
            ],[
                'id'    => 6,
                'ar' => [
                    'plan_name'     => "نصف سنوية",
                    'description'   => "نصف سنوية",
                    'features'      => "نصف سنوية",
                ],
                'en' => [
                    'plan_name'     => "Semi-annual",
                    'description'   => "Semi-annual",
                    'features'      => "Semi-annual",
                ],
                'plan_duration_id'  => 6,
                'trail_period'      => 0,
                'price'             => 500,
            ],
        ];
        foreach($plans as $plan){
            PlanManagement::create($plan);
        }
    }
}
