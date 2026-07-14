<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;

class MylistTest extends TestCase
{
    use RefreshDatabase;

   public function test_only_favorited_items_are_displayed_in_mylist()
   {
    $user = User::create([
        'name' => 'テストユーザー',
        'email' => 'favorite@example.com',
        'password' => bcrypt('password123'),
    ]);

    $seller = User::create([
        'name' => '出品者',
        'email' => 'seller@example.com',
        'password' => bcrypt('password123'),
    ]);

    $item = Item::create([
        'name' => 'いいね商品',
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

    $response = $this->actingAs($user)->get('/?tab=mylist');

    $response->assertStatus(200);
    $response->assertSee('いいね商品');
   }

    public function test_sold_label_is_displayed_in_mylist_for_purchased_items()
    {
     $user = User::create([
        'name' => 'テストユーザー',
        'email' => 'favorite2@example.com',
        'password' => bcrypt('password123'),
     ]);

     $seller = User::create([
        'name' => '出品者',
        'email' => 'seller2@example.com',
        'password' => bcrypt('password123'),
     ]);

     $item = Item::create([
        'name' => '売り切れ商品',
        'price' => 3000,
        'brand' => 'ブランド',
        'description' => '説明',
        'condition' => 1,
        'status' => 1,
        'user_id' => $seller->id,
     ]);

     Favorite::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
     ]);

     $response = $this->actingAs($user)->get('/?tab=mylist');

     $response->assertStatus(200);
     $response->assertSee('Sold');
    }

    public function test_guest_cannot_view_mylist()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller3@example.com',
            'password' => bcrypt('password123'),
        ]);

        Item::create([
            'name' => 'いいね商品',
            'price' => 3000,
            'brand' => 'ブランド',
            'description' => '説明',
            'condition' => 1,
            'status' => 0,
            'user_id' => $seller->id,
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertDontSee('いいね商品');
    }
}
