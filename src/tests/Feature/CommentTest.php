<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_post_comment()
    {
        $user = User::create([
            'name' => 'コメントユーザー',
            'email' => 'comment@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller-comment@example.com',
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

        $response = $this->actingAs($user)->post("/items/{$item->id}/comments", [
            'comment' => 'これはテストコメントです',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'これはテストコメントです',
        ]);
    }

    public function test_guest_cannot_post_comment()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller-guest-comment@example.com',
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

        $response = $this->post("/items/{$item->id}/comments", [
            'comment' => 'ゲストコメント',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_comment_is_required()
    {
        $user = User::create([
            'name' => 'コメントユーザー',
            'email' => 'required-comment@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller-required-comment@example.com',
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

        $response = $this->actingAs($user)->post("/items/{$item->id}/comments", [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors('comment');
    }

    public function test_comment_must_be_less_than_or_equal_to_255_characters()
    {
       $user = User::create([
        'name' => 'コメントユーザー',
        'email' => 'long-comment@example.com',
        'password' => bcrypt('password123'),
        'email_verified_at' => now(),
       ]);

       $seller = User::create([
        'name' => '出品者',
        'email' => 'seller-long-comment@example.com',
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

       $longComment = str_repeat('あ', 256);

       $response = $this->actingAs($user)->post("/items/{$item->id}/comments", [
        'comment' => $longComment,
       ]);

       $response->assertSessionHasErrors('comment');
    }
}

