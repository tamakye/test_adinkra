<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'BRACELETS', 'slug' => 'BRACELET-jewelry', 'collection_id' => 1],
            ['name' => 'EARRINGS', 'slug' => 'EARRINGS-jewelry', 'collection_id' => 1],
            ['name' => 'PENDANTS', 'slug' => 'PENDANTS-jewelry', 'collection_id' => 1],
            ['name' => 'NECKLACE', 'slug' => 'NECKLACE-pieces', 'collection_id' => 1],
            ['name' => 'RINGS', 'slug' => 'digital-collections', 'collection_id' => 1],

            ['name' => 'BRACELETS', 'slug' => 'BRACELET-jewelry-2', 'collection_id' => 2],
            ['name' => 'EARRINGS', 'slug' => 'EARRINGS-jewelry-2', 'collection_id' => 2],
            ['name' => 'PENDANTS', 'slug' => 'PENDANTS-jewelry-2', 'collection_id' => 2],
            ['name' => 'NECKLACE', 'slug' => 'NECKLACE-pieces-2', 'collection_id' => 2],
            ['name' => 'RINGS', 'slug' => 'digital-collections-2', 'collection_id' => 2],

            ['name' => 'BRACELETS', 'slug' => 'BRACELET-jewelry-3', 'collection_id' => 3],
            ['name' => 'EARRINGS', 'slug' => 'EARRINGS-jewelry-3', 'collection_id' => 3],
            ['name' => 'PENDANTS', 'slug' => 'PENDANTS-jewelry-3', 'collection_id' => 3],
            ['name' => 'NECKLACE', 'slug' => 'NECKLACE-pieces-3', 'collection_id' => 3],
            ['name' => 'RINGS', 'slug' => 'digital-collections-3', 'collection_id' => 3],

            ['name' => 'BRACELETS', 'slug' => 'BRACELET-jewelry-4', 'collection_id' => 4],
            ['name' => 'EARRINGS', 'slug' => 'EARRINGS-jewelry-4', 'collection_id' => 4],
            ['name' => 'PENDANTS', 'slug' => 'PENDANTS-jewelry-4', 'collection_id' => 4],
            ['name' => 'NECKLACE', 'slug' => 'NECKLACE-pieces-4', 'collection_id' => 4],
            ['name' => 'RINGS', 'slug' => 'digital-collections-4', 'collection_id' => 4],

            ['name' => 'BRACELETS', 'slug' => 'BRACELET-jewelry-5', 'collection_id' => 5],
            ['name' => 'EARRINGS', 'slug' => 'EARRINGS-jewelry-5', 'collection_id' => 5],
            ['name' => 'PENDANTS', 'slug' => 'PENDANTS-jewelry-5', 'collection_id' => 5],
            ['name' => 'NECKLACE', 'slug' => 'NECKLACE-pieces-5', 'collection_id' => 5],
            ['name' => 'RINGS', 'slug' => 'digital-collections-5', 'collection_id' => 5],

            ['name' => 'BRACELETS', 'slug' => 'BRACELET-jewelry-6', 'collection_id' => 6],
            ['name' => 'EARRINGS', 'slug' => 'EARRINGS-jewelry-6', 'collection_id' => 6],
            ['name' => 'PENDANTS', 'slug' => 'PENDANTS-jewelry-6', 'collection_id' => 6],
            ['name' => 'NECKLACE', 'slug' => 'NECKLACE-pieces-6', 'collection_id' => 6],
            ['name' => 'RINGS', 'slug' => 'digital-collections-6', 'collection_id' => 6],
        ];
        
        DB::table('categories')->insert($data);
    }
}
