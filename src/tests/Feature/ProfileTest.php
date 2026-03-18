<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Address;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_displays_user_information()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'profile@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        Address::create([
            'user_id' => $user->id,
            'postcode' => '123-4567',
            'address' => '東京都テスト1-1-1',
            'building' => 'テストビル',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都テスト1-1-1');

    }
}
