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
                'id' => 1,
                'Quantity' => 100,
                'Cost' => 4.99
            ],
            [
                'id' => 2,
                'Quantity' => 300,
                'Cost' => 12.99
            ],
            [
                'id' => 3,
                'Quantity' => 500,
                'Cost' => 19.99
            ],
            [
                'id' => 4,
                'Quantity' => 1000,
                'Cost' => 34.99
            ]
    ]);
    }
}
