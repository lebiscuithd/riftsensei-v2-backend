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
<<<<<<< HEAD
        \App\Models\User::factory(10)->create();
=======
        \App\Models\User::factory(15)->create();
>>>>>>> f3d00a91223bf70b3b26d8b5b06c4522416b3d4f

        foreach (User::all() as $user) {
            $lanes = \App\Models\Lane::inRandomOrder()->take(rand(1,3))->pluck('id');
            $user->lanes()->attach($lanes);
        }
    }
}
