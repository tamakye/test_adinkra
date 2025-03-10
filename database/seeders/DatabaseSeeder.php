<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $this->call([
            CollectionSeeder::class,
            ConditionSeeder::class,
            CategorySeeder::class,
            MaterialSeeder::class,
            CountrySeeder::class,
            RegionSeeder::class,
            ShippingSeeder::class,
            PageSeeder::class,
        ]);
        
        // \App\Models\Product::factory(20)->create();
    }
}
