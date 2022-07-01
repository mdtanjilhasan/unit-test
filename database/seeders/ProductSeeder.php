<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Fruit tea',
                'code' => 'FR1',
                'price' => 3.11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Strawberries',
                'code' => 'SR1',
                'price' => 5.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coffee',
                'code' => 'CF1',
                'price' => 11.23,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
