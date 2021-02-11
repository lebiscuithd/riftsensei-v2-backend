<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ranks')->insert([
            [
                'id' => 1,
                'name' => 'Unranked',
                'image' => 'https://i.ibb.co/kq8PwQ3/image.png',
            ],
            [
                'id' => 2,
                'name' => 'Iron',
                'image' => 'https://opgg-static.akamaized.net/images/medals/iron_1.png',
            ],
            [
                'id' => 3,
                'name' => 'Bronze',
                'image' => 'https://lolg-cdn.porofessor.gg/img/league-icons-v2/160/2-1.png',
            ],
            [
                'id' => 4,
                'name' => 'Silver',
                'image' => 'https://lolg-cdn.porofessor.gg/img/league-icons-v2/160/3-1.png',
            ],
            [
                'id' => 5,
                'name' => 'Gold',
                'image' => 'https://lolg-cdn.porofessor.gg/img/league-icons-v2/160/4-1.png',
            ],
            [
                'id' => 6,
                'name' => 'Platinium',
                'image' => 'https://lolg-cdn.porofessor.gg/img/league-icons-v2/160/5-1.png'
            ],
            [
                'id' => 7,
                'name' => 'Diamond',
                'image' => 'https://emoji.gg/assets/emoji/6018_Diamond.png',
            ],
            [
                'id' => 8,
                'name' => 'Master',
                'image' => 'https://lolg-cdn.porofessor.gg/img/league-icons-v2/160/7-1.png',
            ],
            [
                'id' => 9,
                'name' => 'Grand Master',
                'image' => 'https://emoji.gg/assets/emoji/2647_Grandmaster.png',
            ],
            [
                'id' => 10,
                'name' => 'Challenger',
                'image' => 'https://emoji.gg/assets/emoji/2506_Challenger.png',
            ],
        ]);
    }
}
