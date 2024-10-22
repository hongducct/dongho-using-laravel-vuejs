<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạm thời vô hiệu hóa ràng buộc khóa ngoại
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
        // Xóa tất cả các bản ghi hiện có trong bảng
        \DB::table("images")->truncate();

        // Thiết lập lại auto-increment cho cột ID
        \DB::statement('ALTER TABLE images AUTO_INCREMENT = 1');

        \DB::table('images')->insert([
            ['product_id' => 1, 'image_path' => 'https://scontent.fhan5-2.fna.fbcdn.net/v/t39.30808-6/433463592_1141004917341903_1870225765760398777_n.jpg?stp=cp6_dst-jpg&_nc_cat=105&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeEoRwsycwhIZ8i8LFg8qNWyD6YESwZKlroPpgRLBkqWugkkFO6qT0-N9KozbI_skgMJbWTowZL8c3EGgsL8J_u6&_nc_ohc=oyw43WLSiogAb55NLsJ&_nc_ht=scontent.fhan5-2.fna&oh=00_AfDWT9RBVuVfSUwGhuWPZaC-IwunVma1TwPmurtobhC_GQ&oe=661FEACF'],
            ['product_id' => 2, 'image_path' => 'https://scontent.fhan5-11.fna.fbcdn.net/v/t39.30808-6/430301924_1134940151281713_4677101684543210544_n.jpg?stp=cp6_dst-jpg&_nc_cat=107&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeGIbRE72MsXpmzcsrvSYgoLqh3K4fSL9S6qHcrh9Iv1Lr1Bge2acW-ToqjCPOvrp-HCKwzfbCPLfcBjjVQWWb9S&_nc_ohc=rJjTVuVvFDkAb7UpTpG&_nc_ht=scontent.fhan5-11.fna&oh=00_AfDSsdWambPW0AYJQPRFS-DeUCC-qzjCe4jm5SRACa3uhw&oe=661FE099'],
        ]);

        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
