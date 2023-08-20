<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = array(
          array('id' => '1','top_slider_one' => 'WELCOME TO 3DINKRA, A POETIC GASP OF AFRICAN ART','top_slider_two' => 'NEW COLLECTION COMING SOON','top_slider_three' => 'SUBSCRIBE TO OUR NEWSLETTERS SO YOU DON’T MISS OUR NEW COLLECTIONS','adinkra_text' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.','adinkra_image_heading' => 'STONE OF AGES','adinkra_image_text' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.','legacy_text' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.','legacy_image_heading' => 'STONE OF AGES','legacy_image_text' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.','custom_text' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.','custom_image_heading' => NULL,'custom_image_text' => NULL,'art_text' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.','art_image_heading' => 'STONE OF AGES','art_image_text' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.','digital_text' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.','digital_image_heading' => NULL,'digital_image_text' => NULL,'created_at' => '2023-06-25 08:19:36','updated_at' => '2023-06-25 08:21:09')
      );

        DB::table('pages')->insert($pages);
    }
}
