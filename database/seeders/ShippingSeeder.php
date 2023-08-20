<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'shipping_location' => 'International Shipping', 
                'charge_type' => 'percentage', 
                'shipping_fee' => 15, 
                'slug' => strtotime(now()), 
                'default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('shippings')->insert($data);
    }
}
