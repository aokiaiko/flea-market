<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class ItemCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_item()
    {
        Storage::fake('public');

        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $category =Category::create([
            'name' => 'テストカテゴリ'
        ]);

        $response = $this->actingAs($user)->post('/sell', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 5000,
            'condition' => 1,
            'category_ids' => [$category->id],
            'images' => [
               UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
            ]
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 5000,
        ]);
    }

}
