<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        // \App\Models\Lane::factory(6)->create();
        // \App\Models\Rank::factory(9)->create();
        // \App\Models\UserLane::factory(9)->create();
//        \App\Models\Ad::factory(10)->create();


        $this->call([
            RankSeeder::class,
            LaneSeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            ReceiptSeeder::class,
            AdSeeder::class
        ]);
    }
}
