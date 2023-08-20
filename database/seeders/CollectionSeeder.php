<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = [
        ['name' => 'ADINKRA JEWELRY', 'slug' => 'adinkra-jewelry'],
        ['name' => 'LEGACY JEWELRY', 'slug' => 'legacy-jewelry'],
        ['name' => 'CUSTOM JEWELRY', 'slug' => 'custom-jewelry'],
        ['name' => 'ART PIECES', 'slug' => 'art-pieces'],
        ['name' => 'DIGITAL COLLECTIBLES', 'slug' => 'digital-collections'],
        ['name' => 'HOUSE OF 3DINKRA', 'slug' => 'house-of-adinkra'],
     ];

     DB::table('collections')->insert($data);
  }
}
