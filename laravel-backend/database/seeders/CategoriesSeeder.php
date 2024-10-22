<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạm thời vô hiệu hóa ràng buộc khóa ngoại
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Xóa tất cả các bản ghi hiện có trong bảng
        \DB::table("categories")->truncate();

        // Thiết lập lại auto-increment cho cột ID
        \DB::statement('ALTER TABLE categories AUTO_INCREMENT = 1');

        \DB::table('categories')->insert([
            ['name' => 'Đồng hồ Nam'],
            ['name' => 'Đồng hồ Nữ'],
            ['name' => 'Đồng hồ Thể thao'],
            ['name' => 'Đồng hồ Thông minh'],
        ]);

        // Kích hoạt lại ràng buộc khóa ngoại
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
