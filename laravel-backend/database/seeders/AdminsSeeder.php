<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("admins")->insert([
            "username" => "adminroot",
            "name" => "Hong Duc",
            "email" => "hongducct23@gmail.com",
            "password" => \Hash::make("123456"),
        ]);
    }
}
