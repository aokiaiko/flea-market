<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'テストユーザー1',
            'email' => 'test@test.com',
            'password'=>bcrypt('password'),
            
        ]);

        User::create([
            'name' => 'テストユーザー2',
            'email' => 'test2@test.com',
            'password' => bcrypt('password'),
        ]);
    }
       
}
