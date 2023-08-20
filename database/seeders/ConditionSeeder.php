<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'AVAILABLE ONLINE', 'slug' => 'available-online'],
            ['name' => 'NEW', 'slug' => 'new'],
            ['name' => 'MUST HAVE', 'slug' => 'must-have'],
            ['name' => 'HER', 'slug' => 'her'],
            ['name' => 'HIM', 'slug' => 'him'],
            ['name' => 'CHILDREN', 'slug' => 'children'],
        ];

        DB::table('conditions')->insert($data);
    }
}
