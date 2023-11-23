<?php

namespace Database\Seeders;

use App\Models\MeasurementUnit;
use Illuminate\Database\Seeder;

class MeasurementUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = config('measurement-units.measurement-units');

        foreach ($types as $id => $type) {
            MeasurementUnit::create(
                [
                    'id'    => $id,
                    'ar' => [
                        'name'   => $type['ar']
                    ],
                    'en' => [
                        'name'   => $type['en']
                    ],
                ]
            );
        }
    }
}
