<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("users")->insert([
            "username" => "user1",
            "name" => "Hong Duc",
            "email" => "hongducct100@gmail.com",
            "password" => \Hash::make("123456"),
            "status_id" => 1,	// Hoạt động
        ]);
        \DB::table("users")->insert([
            "username" => "user2",
            "name" => "Hong Duc nè",
            "email" => "hongducct@gmail.com",
            "password" => \Hash::make("123456"),
            "status_id" => 2,	// Hoạt động
        ]);
    }
}
