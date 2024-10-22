<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Users_Status_Seeder extends Seeder
{
    
    public function run(): void
    {
        // Tạm thời vô hiệu hóa ràng buộc khóa ngoại
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
        // Xóa tất cả các bản ghi hiện có trong bảng
        \DB::table("users_status")->truncate();
    
        // Thiết lập lại auto-increment cho cột ID
        \DB::statement('ALTER TABLE users_status AUTO_INCREMENT = 1');

        \DB::table("users_status")->insert([
            ["name" => "Hoạt động"],
            ["name" => "Tạm khóa"],
        ]);
    
        // Kích hoạt lại ràng buộc khóa ngoại
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
