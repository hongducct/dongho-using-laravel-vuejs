<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạm thời vô hiệu hóa ràng buộc khóa ngoại
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
        // Xóa tất cả các bản ghi hiện có trong bảng
        \DB::table("attributes")->truncate();

        // Thiết lập lại auto-increment cho cột ID
        \DB::statement('ALTER TABLE attributes AUTO_INCREMENT = 1');

        \DB::table('attributes')->insert([
            ['product_id' => 1, 'movement' => 'Tự động', 'case' => 'Thép không gỉ', 'strap' => 'Dây đeo', 'water_resistance' => '300 mét'],
            ['product_id' => 2, 'movement' => 'Thủ công', 'case' => 'Thép không gỉ', 'strap' => 'Dây đeo', 'water_resistance' => '50 mét'],
        ]);

        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
