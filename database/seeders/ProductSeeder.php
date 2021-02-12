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
                'Cost' => 4.99,
                'image' => 'https://i.postimg.cc/tgYfBGwM/100gems.png'
            ],
            [
                'id' => 2,
                'Quantity' => 300,
                'Cost' => 12.99,
                'image' => 'https://i.postimg.cc/cJ2zj5N4/300gems.png'
            ],
            [
                'id' => 3,
                'Quantity' => 500,
                'Cost' => 19.99,
                'image' => 'https://i.postimg.cc/153KGcLW/500gems.png'
            ],
            [
                'id' => 4,
                'Quantity' => 1000,
                'Cost' => 34.99,
                'image' => 'https://i.postimg.cc/MHWmryXp/1000gems.png'
            ]
    ]);
    }
}
