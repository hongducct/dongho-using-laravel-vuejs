<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            AdminsSeeder::class,
            Users_Status_Seeder::class,
            Orders_Status_Seeder::class,
            UsersSeeder::class,
            CategoriesSeeder::class,
            AttributesSeeder::class,
            ProductsSeeder::class,
            ImagesSeeder::class,
            // OrdersSeeder::class,
            
        ]);
    }
}
