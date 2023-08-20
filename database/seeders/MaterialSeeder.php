<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = [
         ['name' => 'GOLD', 'slug' => 'gold'],
         ['name' => 'ROSE GOLD ', 'slug' => 'rose-gold'],
         ['name' => 'SILVER', 'slug' => 'silver'],
         ['name' => 'WHITE GOLD', 'slug' => 'white-gold'],
      ];

      DB::table('materials')->insert($data);
   }
}
