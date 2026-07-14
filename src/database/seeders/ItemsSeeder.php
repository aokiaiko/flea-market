<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        
        $user1 = $users[0];
        $user2 = $users[1];

        Item::create([
            'name' => '腕時計',
            'price' => 15000,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'condition' => '良好',
            'status' => 0,
            'user_id' => $user1->id,
        ]);

        Item::create([
            'name' => 'HDD',
            'price' => 5000,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'condition' => '目立った傷や汚れなし',
            'status' => 0,
            'user_id' => $user2->id,
        ]);
        
        Item::create([
            'name' => '玉ねぎ3束',
            'price' => 300,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'condition' => 'やや傷や汚れあり',
            'status' => 0,
            'user_id' => $user1->id,
        ]);
        
        Item::create([
            'name' => '革靴',
            'price' => 4000,
            'description' => 'クラシックなデザインの革靴',
            'condition' => '状態が悪い',
            'status' => 0,
            'user_id' => $user2->id,
        ]);
        
        Item::create([
            'name' => 'ノートPC',
            'price' => 45000,
            'description' => '高性能なノートパソコン',
            'condition' => '良好',
            'status' => 0,
            'user_id' => $user1->id,
        ]);
        
        Item::create([
            'name' => 'マイク',
            'price' => 8000,
            'brand'=>'なし',
            'description' => '高音質のレコーディング用マイク',
            'condition' => '目立った傷や汚れなし',
            'status' => 0,
            'user_id' => $user2->id,
        ]);
       
        Item::create([
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'description' => 'おしゃれなショルダーバッグ',
            'condition' => 'やや傷や汚れあり',
            'status' => 0,
            'user_id' => $user1->id,
        ]);
       
         Item::create([
            'name' => 'タンブラー',
            'price' => 500,
            'description' => '使いやすいタンブラー',
            'condition' => '状態が悪い',
            'status' => 0,
            'user_id' => $user2->id,
        ]);
        
        Item::create([
            'name' => 'コーヒーミル',
            'price' => 4000,
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'condition' => '良好',
            'status' => 0,
            'user_id' => $user1->id,
        ]);
        
        Item::create([
            'name' => 'メイクセット',
            'price' => 2500,
            'description' => '便利なメイクアップセット',
            'condition' => '目立った傷や汚れなし',
            'status' => 0,
            'user_id' => $user2->id,
        ]);
        
    }
}
