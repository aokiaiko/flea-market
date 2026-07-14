<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_exhibit_item()
    {
        Storage::fake('public');

        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'sell@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $image = UploadedFile::fake()->create('item.jpg',100, 'image/jpeg');

        $category = Category::create([
           'name' => 'テストカテゴリー',
        ]);

        $response = $this->actingAs($user)->get('/sell');

        $response->assertStatus(200);

        $response = $this->actingAs($user)->post('/sell', [
            'name' => 'テスト商品',
            'price' => 3000,
            'brand' => 'テストブランド',
            'description' => 'テスト用の商品説明です',
            'condition' => '良好',
            'category_ids' => [$category->id],
            'images' => [$image],
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'price' => 3000,
            'brand' => 'テストブランド',
            'description' => 'テスト用の商品説明です',
            'condition' => '良好',
            'user_id' => $user->id,
        ]);

        $item = Item::where('name', 'テスト商品')->firstOrFail();

        $this->assertDatabaseHas('category_item', [
           'item_id' => $item->id,
           'category_id' => [$category->id],
        ]);
    }  
}
