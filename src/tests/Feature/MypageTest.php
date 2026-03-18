<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Address;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_name_is_displayed_on_mypage()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'mypage@example.com',
            'password' => bcrypt('password123'),
            'profile_image' => 'profiles/test.jpg',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
    }

    public function test_profile_image_is_displayed_on_mypage()
    {
    $user = User::create([
        'name' => '画像ユーザー',
        'email' => 'image@example.com',
        'password' => bcrypt('password123'),
        'profile_image' => 'profiles/test.jpg',
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->get('/mypage');

    $response->assertStatus(200);
    $response->assertSee('profiles/test.jpg');
    }

    public function test_selling_items_are_displayed_on_mypage()
    {
        $user = User::create([
            'name' => '出品ユーザー',
            'email' => 'seller@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        Item::create([
            'name' => '出品商品',
            'price' => 3000,
            'brand' => 'ブランド',
            'description' => '説明',
            'condition' => 1,
            'status' => 0,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=sell');

        $response->assertStatus(200);
        $response->assertSee('出品商品');
    }

    public function test_purchased_items_are_displayed_on_mypage()
    {
        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buy@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller2@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $item = Item::create([
            'name' => '購入商品',
            'price' => 5000,
            'brand' => 'ブランド',
            'description' => '説明',
            'condition' => 1,
            'status' => 1,
            'user_id' => $seller->id,
        ]);

        $address = Address::create([
            'user_id' => $buyer->id,
            'postcode' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル',
        ]);

        Purchase::create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'address_id' => $address->id,
            'price' => 5000,
            'status' => 1,
            'payment_method' => 'card',
        ]);

        $response = $this->actingAs($buyer)->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('購入商品');
    }

    public function test_profile_edit_form_has_initial_values()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'profile@example.com',
            'password' => bcrypt('password123'),
            'profile_image' => 'profiles/test.jpg',
            'email_verified_at' => now(),
        ]);

        Address::create([
            'user_id' => $user->id,
            'postcode' => '111-2222',
            'address' => '東京都新宿区1-1-1',
            'building' => 'テストマンション',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('111-2222');
        $response->assertSee('東京都新宿区1-1-1');
    }

}