<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Product_Attributes_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạm thời vô hiệu hóa ràng buộc khóa ngoại
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
        // Xóa tất cả các bản ghi hiện có trong bảng
        \DB::table("product_attributes")->truncate();

        // Thiết lập lại auto-increment cho cột ID
        \DB::statement('ALTER TABLE product_attributes AUTO_INCREMENT = 1');

        \DB::table('product_attributes')->insert([
            ['product_id' => 1, 'attribute_id' => 1, 'value' => 'Tự động'],
            ['product_id' => 1, 'attribute_id' => 2, 'value' => 'Thép không gỉ'],
            ['product_id' => 1, 'attribute_id' => 3, 'value' => 'Dây đeo'],
            ['product_id' => 1, 'attribute_id' => 4, 'value' => '300 mét'],
            ['product_id' => 2, 'attribute_id' => 1, 'value' => 'Thủ công'],
            ['product_id' => 2, 'attribute_id' => 2, 'value' => 'Thép không gỉ'],
            ['product_id' => 2, 'attribute_id' => 3, 'value' => 'Dây đeo'],
            ['product_id' => 2, 'attribute_id' => 4, 'value' => '50 mét'],
        ]);

        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
