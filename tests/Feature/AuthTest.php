<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_can_login_using_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);

    }

    public function test_get_registration_page()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }
}
