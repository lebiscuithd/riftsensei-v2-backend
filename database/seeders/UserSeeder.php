<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(User::class, 5)->create();
        \App\Models\User::factory(5)->create();

        foreach (User::all() as $user) {
            $lanes = \App\Models\Lane::inRandomOrder()->take(rand(1,3))->pluck('id');
            $user->lanes()->attach($lanes);
        }
    }
}
