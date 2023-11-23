<?php

namespace Tests\Feature\API;

use App\Models\Day;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->artisan('passport:install');
    }

    public function test_register_new_client_with_empty_full_name_return_422_status_code()
    {
        $client = [
            'full_name' => '',
            'email'     => 'test@email.com',
            'mobile'    => '512345678',
            'password'  => bcrypt(123456789),
        ];
        $response = $this->postJson('api/v1/register', $client);
        $response->assertUnprocessable(); // 422
        $response->assertJsonPath('code', 422);
        $response->assertJsonPath('message', "The full name field is required.");
    }

    public function test_register_new_client_with_empty_email_return_422_status_code()
    {
        $client = [
            'full_name' => 'New Client',
            'email'     => '',
            'mobile'    => '512345678',
            'password'  => bcrypt(123456789),
        ];
        $response = $this->postJson('api/v1/register', $client);
        $response->assertUnprocessable(); // 422
        $response->assertJsonPath('code', 422);
        $response->assertJsonPath('message', "The email field is required.");
    }

    public function test_register_new_client_with_empty_mobile_return_422_status_code()
    {
        $client = [
            'full_name' => 'New Client',
            'email'     => 'test@test.com',
            'mobile'    => '',
            'password'  => bcrypt(123456789),
        ];
        $response = $this->postJson('api/v1/register', $client);
        $response->assertUnprocessable(); // 422
        $response->assertJsonPath('code', 422);
        $response->assertJsonPath('message', "The mobile field is required.");
    }

    public function test_register_new_client_with_empty_password_return_422_status_code()
    {
        $client = [
            'full_name' => 'New Client',
            'email'     => 'test@test.com',
            'mobile'    => '512345678',
            'password'  => '',
        ];
        $response = $this->postJson('api/v1/register', $client);
        $response->assertUnprocessable(); // 422
        $response->assertJsonPath('code', 422);
        $response->assertJsonPath('message', "The password field is required.");
    }

    public function test_register_new_client_successfully()
    {
        $client = [
            'full_name' => 'Client Name',
            'email'     => 'test@email.com',
            'mobile'    => '512345644',
            'password'  => bcrypt(123456789),
        ];

        $days = [
            [
                'id'     => 1,
                'value'  => 'Day One',
                'day'    => 1,
            ],
            [
                'id'     => 2,
                'value'  => 'Day Two',
                'day'    => 2,
            ],
            [
                'id'     => 3,
                'value'  => 'Day Three',
                'day'    => 3,
            ],
            [
                'id'     => 4,
                'value'  => 'Day Four',
                'day'    => 4,
            ],
            [
                'id'     => 5,
                'value'  => 'Day Five',
                'day'    => 5,
            ],
            [
                'id'     => 6,
                'value'  => 'Day Six',
                'day'    => 6,
            ],
            [
                'id'     => 7,
                'value'  => 'Day Seven',
                'day'    => 7,
            ],
        ];
        foreach($days as $day){
            Day::create($day);
        }
        $response = $this->postJson('api/v1/register', $client);

        $response->assertSuccessful(); // 200
        $response->assertJsonPath('payload.full_name', $client['full_name']);
        $response->assertJsonPath('payload.email', $client['email']);
        $response->assertJsonStructure([
            'code',
            'error',
            'message',
            'payload' => [
                'id',
                'full_name',
                'email',
                'mobile',
                'age',
                'gender',
                'image',
                'is_verified',
                'status',
                'goal',
                'level',
                'weight',
                'height',
                'serving_reset_time',
                'created_at',
                'updated_at',
                'token'
            ]
        ]);
    }
}
