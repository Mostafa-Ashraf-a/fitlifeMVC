<?php

namespace Tests\Feature\Dashboard\Controllers\Nutrition;

use App\Models\MeasurementUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeasurementUnitTest extends TestCase
{
    use RefreshDatabase;
    private $baseUrl = '/manager/nutrition/measurement-units';
    public function test_measurement_unit_index_page_return_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->manager)->get($this->baseUrl);
        $response->assertOk();
    }

    public function test_measurement_unit_index_page_return_not_found()
    {
        $response = $this->actingAs($this->manager)->get($this->baseUrl . 'test');
        $response->assertNotFound();
    }

    public function test_store_new_measurement_unit()
    {
        $model =
            [
                'name_ar'   => 'كوب',
                'name_en'     => 'Cup',
            ];
        $response = $this->actingAs($this->manager)->post($this->baseUrl, $model);
        $response->assertStatus(302);
    }

    public function test_measurement_unit_index_page_contains_table_measurement_unit()
    {
        $model =
            [
                'name_ar'   => 'كوب',
                'name_en'     => 'Cup',
            ];
        $this->actingAs($this->manager)->post($this->baseUrl, $model);
        $response = $this->actingAs($this->manager)->get($this->baseUrl);
        $response->assertOk();
        $response->assertSeeText($model['name_en']);
    }

}
