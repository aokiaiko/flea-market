<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
     $response = $this->post('/register', [
        'name' => 'テストユーザー',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
     ]);

     $response->assertRedirect('/email/verify');
 
     $this->assertDatabaseHas('users', [
        'email' => 'test@example.com'
     ]);
    }

    public function test_name_is_required()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_email_is_required()
    {
     $response = $this->post('/register', [
        'name' => 'テストユーザー',
        'email' => '',
        'password' => 'password123',
        'password_confirmation' => 'password123'
     ]);

     $response->assertSessionHasErrors('email');
    }

    public function test_password_confirmation_does_not_match()
    {
     $response = $this->post('/register', [
        'name' => 'テストユーザー',
        'email' => 'mismatch@example.com',
        'password' => 'password123',
        'password_confirmation' => 'different123'
     ]);

     $response->assertSessionHasErrors('password');
    }

    public function test_email_must_be_valid()
    {
     $response = $this->post('/register', [
        'name' => 'テストユーザー',
        'email' => 'testexample.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
     ]);

     $response->assertSessionHasErrors('email');
    }

    public function test_password_must_be_at_least_8_characters()
    {
     $response = $this->post('/register', [
        'name' => 'テストユーザー',
        'email' => 'shortpass@example.com',
        'password' => '1234567',
        'password_confirmation' => '1234567'
     ]);

     $response->assertSessionHasErrors('password');
    }

    public function test_password_is_required()
    {
     $response = $this->post('/register', [
        'name' => 'テストユーザー',
        'email' => 'test@example.com',
        'password' => '',
        'password_confirmation' => ''
     ]);

     $response->assertSessionHasErrors('password');
    }
}
