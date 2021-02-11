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
                'image' => 'caca'
            ],
            [
                'name' => 'Jungle',
                'image' => 'coco'
            ],
            [
                'name' => 'Midlane',
                'image' => 'cucu'
            ],
            [
                'name' => 'Botlane',
                'image' => 'cece'
            ],
            [
                'name' => 'Support',
                'image' => 'cmcm'
            ],
        ]);
    }
}
