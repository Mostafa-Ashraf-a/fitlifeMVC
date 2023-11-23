<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeerder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = [

                'id'    => 1,
                'ar' => [
                    'privacy_policy'    => "سياسة الخصوصية",
                    'terms_of_service'  => "الشروط والأحكام",
                    'about_us'          => "من نحن",
                ],
                'en' => [
                    'privacy_policy'   => "privacy policy",
                    'terms_of_service' => "terms of service",
                    'about_us'         => "about us",
                ],

        ];
        Setting::create($setting);
    }
}




