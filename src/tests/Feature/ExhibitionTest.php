<?php

/*namespace Tests\Feature;

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
        ]);

        $image = UploadedFile::fake()->create('item.jpg',100, 'image/jpeg');

        $response = $this->actingAs($user)->post('/sell', [
            'name' => 'テスト商品',
            'price' => 3000,
            'brand' => 'テストブランド',
            'description' => 'テスト用の商品説明です',
            'condition' => 1,
            'category_id' => 1,
            'images' => [$image],
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'price' => 3000,
            'brand' => 'テストブランド',
            'description' => 'テスト用の商品説明です',
            'user_id' => $user->id,
        ]);
    }



    
}*/
