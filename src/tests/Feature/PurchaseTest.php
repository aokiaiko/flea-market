<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\ItemImage;
use App\Models\Address;

class PurchaseTest extends TestCase
{
    public function test_user_can_purchase_item()
    {
        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
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

        $address = Address::create([
            'user_id' => $buyer->id,
            'postcode' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル',
        ]);

        $response = $this->actingAs($buyer)->post("/purchase/{$item->id}", [
            'payment_method' => 'card',
            'address_id' => $address->id,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'address_id' => $address->id,
            'payment_method' => 'card',
        ]);
    }

    public function test_purchased_item_is_marked_as_sold_in_index()
    {
        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer2@example.com',
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
            'name' => '購入済み商品',
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

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    public function test_purchased_item_is_displayed_in_profile()
    {
        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer3@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller3@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $item = Item::create([
            'name' => '購入済み商品',
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
            'payment_method' => 'カード',
        ]);

        $response = $this->actingAs($buyer)->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('購入済み商品');
    }

    public function test_selected_payment_method_is_saved()
    {
        $buyer = User::create([
           'name' => '購入者',
           'email' => 'buyer4@example.com',
           'password' => bcrypt('password123'),
           'email_verified_at' => now(),
        ]);

        $seller = User::create([
           'name' => '出品者',
           'email' => 'seller4@example.com',
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

        $address = Address::create([
          'user_id' => $buyer->id,
          'postcode' => '123-4567',
          'address' => '東京都渋谷区1-1-1',
          'building' => 'テストビル',
        ]);

        $this->actingAs($buyer)->post("/purchase/{$item->id}", [
          'payment_method' => 'card',
          'address_id' => $address->id,
        ]);

        $this->assertDatabaseHas('purchases', [
          'item_id' => $item->id,
          'payment_method' => 'card',
        ]);
    }

    public function test_changed_address_is_reflected_on_purchase_page()
    {
        $user = User::create([
          'name' => 'ユーザー',
          'email' => 'address1@example.com',
          'password' => bcrypt('password123'),
          'email_verified_at' => now(),
        ]);

        $seller = User::create([
          'name' => '出品者',
          'email' => 'address2@example.com',
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

        ItemImage::create([
          'item_id' => $item->id,
          'image_path' => 'test.jpg',
        ]);

        $response = $this->actingAs($user)->get("/purchase/address/{$item->id}");
        $response->assertStatus(200);

        $response = $this->actingAs($user)->patch("/purchase/address/{$item->id}", 
        [
          'postcode' => '987-6543',
          'address' => '大阪府大阪市',
          'building' => 'テストマンション',
        ]);
        $response->assertRedirect("/purchase/{$item->id}");

        $response = $this->actingAs($user)->get("/purchase/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('987-6543');
        $response->assertSee('大阪府大阪市');
        $response->assertSee('テストマンション');
    }

    public function test_purchase_is_saved_with_address()
    {
        $buyer = User::create([
          'name' => '購入者',
          'email' => 'address3@example.com',
          'password' => bcrypt('password123'),
          'email_verified_at' => now(),
        ]);

        $seller = User::create([
          'name' => '出品者',
          'email' => 'address4@example.com',
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

        $this->actingAs($buyer)->patch( "/purchase/address/{$item->id}", 
        [
          'postcode' => '123-4567',
          'address' => '東京都渋谷区',
          'building' => 'テストビル',
        ]);

        $address = Address::where('user_id', $buyer->id)
        ->latest()
        ->firstOrFail();

        $this->actingAs($buyer)->post("/purchase/{$item->id}", [
          'payment_method' => 'card',
          'address_id' => $address->id,
        ]);

        $this->assertDatabaseHas('purchases', 
        [
          'user_id' => $buyer->id,
          'item_id' => $item->id,
          'address_id' => $address->id,
        ]);
    }



}
