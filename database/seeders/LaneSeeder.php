<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lanes')->insert([
            [
                'name' => 'Toplane',
                'image' => 'https://static.wikia.nocookie.net/leagueoflegends/images/e/ef/Top_icon.png'
            ],
            [
                'name' => 'Jungle',
                'image' => 'https://static.wikia.nocookie.net/leagueoflegends/images/1/1b/Jungle_icon.png'
            ],
            [
                'name' => 'Midlane',
                'image' => 'https://static.wikia.nocookie.net/leagueoflegends/images/9/98/Middle_icon.png'
            ],
            [
                'name' => 'Botlane',
                'image' => 'https://static.wikia.nocookie.net/leagueoflegends/images/9/97/Bottom_icon.png'
            ],
            [
                'name' => 'Support',
                'image' => 'https://static.wikia.nocookie.net/leagueoflegends/images/e/e0/Support_icon.png'
            ],
        ]);
    }
}
