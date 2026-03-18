<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'login@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'login@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
    }

    public function test_email_is_required_for_login()
    {
    $response = $this->post('/login', [
        'email' => '',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    }

    public function test_password_is_required_for_login()
    {
    $response = $this->post('/login', [
        'email' => 'login@example.com',
        'password' => '',
    ]);

    $response->assertSessionHasErrors('password');
    }

    public function test_user_cannot_login_with_wrong_password()
    {
    $user = User::create([
        'name' => 'テストユーザー',
        'email' => 'login@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post('/login', [
        'email' => 'login@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertSessionHasErrors();
    }

    public function test_user_can_logout()
    {
    $user = User::create([
        'name' => 'テストユーザー',
        'email' => 'logout@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect('/');
    }
}
