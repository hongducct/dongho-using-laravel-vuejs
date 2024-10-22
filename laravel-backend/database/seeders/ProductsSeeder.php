<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        // Tạm thời vô hiệu hóa ràng buộc khóa ngoại
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Xóa tất cả các bản ghi hiện có trong bảng
        \DB::table("products")->truncate();

        // Thiết lập lại auto-increment cho cột ID
        \DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');


        \DB::table('products')->insert([
            [
                'name' => 'Rolex Submariner',
                'brand' => 'Rolex',
                'description' => 'Đồng hồ Rolex Submariner là một biểu tượng trong thế giới đồng hồ, nổi tiếng với độ chính xác và độ bền cao.',
                'price' => 500,
                'stock' => 10,
                'category_id' => 3,
            ],
            [
                'name' => 'Omega Speedmaster',
                'brand' => 'Omega',
                'description' => 'Omega Speedmaster là một trong những mẫu đồng hồ nổi tiếng của Omega, được biết đến với thiết kế thể thao và chức năng đo thời gian.',
                'price' => 750,
                'stock' => 8,
                'category_id' => 3,
            ],
        ]);

        // Kích hoạt lại ràng buộc khóa ngoại
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');

        
    }
}
