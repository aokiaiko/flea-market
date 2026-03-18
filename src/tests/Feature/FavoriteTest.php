<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_favorite_item()
    {
    $user = User::create([
        'name' => 'テストユーザー',
        'email' => 'user@example.com',
        'password' => bcrypt('password123'),
        'email_verified_at' => now(),
    ]);

    $seller = User::create([
        'name' => '出品者',
        'email' => 'seller@example.com',
        'password' => bcrypt('password123'),
        'email_verified_at' => now(),
    ]);

    $item = Item::create([
        'name' => 'テスト商品',
        'price' => 3000,
        'brand' => 'ブランド',
        'description' => '説明',
        'condition' => 1,
        'status' => 0,
        'user_id' => $seller->id,
    ]);

    $response = $this->actingAs($user)->post("/items/{$item->id}/favorite");

    $response->assertRedirect();

    $this->assertDatabaseHas('favorites', [
        'user_id' => $user->id,
        'item_id' => $item->id,
    ]);

    }

    public function test_favorited_item_icon_changes_color()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user2@example.com',
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
            'name' => 'テスト商品',
            'price' => 3000,
            'brand' => 'ブランド',
            'description' => '説明',
            'condition' => 1,
            'status' => 0,
            'user_id' => $seller->id,
        ]);

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get("/item/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('liked', false);
        $response->assertSee('fa-solid fa-heart', false);
    }
    



}
