<?php

namespace Tests\Feature\Dashboard;

use App\Models\Manager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;
    public function test_unauthenticated_user_cannot_access_home()
    {
        $response = $this->get('manager/dashboard');
        $response->assertStatus(302);
        $response->assertRedirect(route('manager.login'));
    }
    public function test_successful_login_redirect_to_home()
    {
        $this->withoutExceptionHandling();
        $manager = Manager::create([
            'username'  => 'Admin',
            'mobile'    => 966512345000,
            'email'     => 'admintest@admin.com',
            'password'  => bcrypt(123456789)
        ]);
        $response = $this->post('manager/check', [
            'email'     => 'admintest@admin.com',
            'password'  => 123456789
        ]);
        $response->assertStatus(302);
        $this->actingAs($manager)->get('manager/dashboard');
    }
}
