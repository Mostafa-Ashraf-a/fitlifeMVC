<?php

namespace Tests\Feature\Dashboard\Marketing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CouponTest extends TestCase
{
    use RefreshDatabase;
    private $baseUrl = '/manager/marketing/coupons';

    public function test_coupons_index_page_return_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->manager)->get($this->baseUrl);
        $response->assertOk();
    }
    public function test_invalid_coupons_url_return_404()
    {
        $response = $this->actingAs($this->manager)->get('/manager/marketing/couponsinvalid');
        $response->assertNotFound();
    }
}
