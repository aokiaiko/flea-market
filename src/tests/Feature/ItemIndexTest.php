<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_items_index_can_be_displayed()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password123'),
        ]);

        Item::create([
            'name' => 'テスト商品',
            'price' => 3000,
            'brand' => 'テストブランド',
            'description' => 'テスト説明',
            'condition' => 1,
            'status' => 0,
            'user_id' => $user->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
    }

    public function test_own_items_are_not_displayed_in_index_for_authenticated_user()
    {
    $user = User::create([
        'name' => 'ログインユーザー',
        'email' => 'loginuser@example.com',
        'password' => bcrypt('password123'),
    ]);

    Item::create([
        'name' => '自分の商品',
        'price' => 3000,
        'brand' => 'ブランド',
        'description' => '説明',
        'condition' => 1,
        'status' => 0,
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->get('/');

    $response->assertStatus(200);
    $response->assertDontSee('自分の商品');
    }

    public function test_sold_label_is_displayed_for_sold_items()
    {
    $user = User::create([
        'name' => '出品者',
        'email' => 'seller@example.com',
        'password' => bcrypt('password123'),
    ]);

    Item::create([
        'name' => '売り切れ商品',
        'price' => 5000,
        'brand' => 'ブランド',
        'description' => '説明',
        'condition' => 1,
        'status' => 1, // 売り切れ
        'user_id' => $user->id,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Sold');
    }

    public function test_items_can_be_searched_by_name()
    {
    $user = User::create([
        'name' => '出品者',
        'email' => 'seller@example.com',
        'password' => bcrypt('password123'),
    ]);

    Item::create([
        'name' => 'iPhoneケース',
        'price' => 3000,
        'brand' => 'Apple',
        'description' => '説明',
        'condition' => 1,
        'status' => 0,
        'user_id' => $user->id,
    ]);

    Item::create([
        'name' => 'MacBookカバー',
        'price' => 5000,
        'brand' => 'Apple',
        'description' => '説明',
        'condition' => 1,
        'status' => 0,
        'user_id' => $user->id,
    ]);

    $response = $this->get('/?keyword=iPhone');

    $response->assertStatus(200);
    $response->assertSee('iPhoneケース');
    $response->assertDontSee('MacBookカバー');
    }

    public function test_search_keyword_is_kept_in_mylist()
    {
    $user = User::create([
        'name' => 'テストユーザー',
        'email' => 'user@example.com',
        'password' => bcrypt('password123'),
    ]);

    $seller = User::create([
        'name' => '出品者',
        'email' => 'seller@example.com',
        'password' => bcrypt('password123'),
    ]);

    $item = Item::create([
        'name' => 'iPhoneケース',
        'price' => 3000,
        'brand' => 'Apple',
        'description' => '説明',
        'condition' => 1,
        'status' => 0,
        'user_id' => $seller->id,
    ]);

    Favorite::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
    ]);

    $response = $this->actingAs($user)->get('/?tab=mylist&keyword=iPhone');

    $response->assertStatus(200);
    $response->assertSee('iPhoneケース');
    }

    public function test_purchased_item_is_displayed_as_sold()
    {
    $seller = User::create([
        'name' => '出品者',
        'email' => 'seller-purchased@example.com',
        'password' => bcrypt('password123'),
    ]);

    Item::create([
        'name' => '購入済み商品',
        'price' => 5000,
        'brand' => 'ブランド',
        'description' => '説明',
        'condition' => 1,
        'status' => 1,
        'user_id' => $seller->id,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Sold');
    }
}
