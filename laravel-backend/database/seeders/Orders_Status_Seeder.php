<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Orders_Status_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Tạm thời vô hiệu hóa ràng buộc khóa ngoại
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Xóa tất cả các bản ghi hiện có trong bảng
        \DB::table("orders_status")->truncate();

        // Thiết lập lại auto-increment cho cột ID
        \DB::statement('ALTER TABLE orders_status AUTO_INCREMENT = 1');

        // Thêm lại các bản ghi với ID bắt đầu từ 1
        \DB::table("orders_status")->insert([
            ["name" => "Chờ xác nhận"],
            ["name" => "Chờ lấy hàng"],
            ["name" => "Chờ giao hàng"],
            ["name" => "Hoàn thành"],
            ["name" => "Hủy"],
            ["name" => "Trả hàng"],
        ]);

        // Kích hoạt lại ràng buộc khóa ngoại
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
