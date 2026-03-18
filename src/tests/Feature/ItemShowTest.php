<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;

   
   public function test_item_detail_information_is_displayed()
   {
    $seller = User::create([
        'name' => '出品者',
        'email' => 'seller@example.com',
        'password' => bcrypt('password123'),
    ]);

    $commentUser = User::create([
            'name' => 'コメントユーザー',
            'email' => 'comment@example.com',
            'password' => bcrypt('password123'),
    ]);

    $item = Item::create([
        'name' => 'テスト商品',
        'price' => 5000,
        'brand' => 'テストブランド',
        'description' => 'テスト商品説明',
        'condition' => 1,
        'status' => 0,
        'user_id' => $seller->id,
    ]);

    ItemImage::create([
            'item_id' => $item->id,
            'image_path' => 'items/test.jpg',
    ]);

    $category = Category::create([
            'name' => 'ファッション',
    ]);

    DB::table('category_item')->insert([
            'item_id' => $item->id,
            'category_id' => $category->id,
    ]);

    Favorite::create([
            'user_id' => $commentUser->id,
            'item_id' => $item->id,
    ]);

    Comment::create([
            'user_id' => $commentUser->id,
            'item_id' => $item->id,
            'comment' => 'とても良い商品です',
    ]);


    $response = $this->get('/item/' . $item->id);

    $response->assertStatus(200);
    $response->assertSee('テスト商品');
    $response->assertSee('テストブランド');
    $response->assertSee('¥5,000');
    $response->assertSee('テスト商品説明');
    $response->assertSee('items/test.jpg');
    $response->assertSee('ファッション');
    $response->assertSee('コメントユーザー');
    $response->assertSee('1');
    $response->assertSee('とても良い商品です'); 
    }

    public function test_multiple_selected_categories_are_displayed()
    {
    $seller = User::create([
        'name' => '出品者',
        'email' => 'seller2@example.com',
        'password' => bcrypt('password123'),
    ]);

    $item = Item::create([
        'name' => 'テスト商品',
        'price' => 5000,
        'brand' => 'ブランド',
        'description' => '説明',
        'condition' => 1,
        'status' => 0,
        'user_id' => $seller->id,
    ]);

    $category1 = Category::create([
        'name' => 'ファッション',
    ]);

    $category2 = Category::create([
            'name' => 'メンズ',
    ]);


    DB::table('category_item')->insert([
         ['item_id' => $item->id,
          'category_id' => $category1->id,
         ],
         [
          'item_id' => $item->id,
          'category_id' => $category2->id,
         ],
    ]);

    $response = $this->get('/item/' . $item->id);

    $response->assertStatus(200);
    $response->assertSee('ファッション');
    $response->assertSee('メンズ');
    }

}    