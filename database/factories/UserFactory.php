<?php

namespace Database\Factories;

use App\Models\Rank;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'rank_id' => Rank::all()->random()->id,
            'description' => $this->faker->text(20),
            'pedagogy' => $this->faker->text(10),
            'admin' => false,
            'wallet' => 100,
            'twitter_link' => 'http://twitter.com',
            'opgg_link' => 'http://op.gg',
            'avatar' => $this->faker->randomElement([
                'http://ddragon.leagueoflegends.com/cdn/10.25.1/img/champion/Aatrox.png', 
                'http://ddragon.leagueoflegends.com/cdn/10.25.1/img/champion/Vladimir.png', 
                'http://ddragon.leagueoflegends.com/cdn/10.25.1/img/champion/Trundle.png', 
                'http://ddragon.leagueoflegends.com/cdn/10.25.1/img/champion/Syndra.png'
                ]),
            'verified_coach' => $this->faker->boolean(),
            'coaching_hours' => $this->faker->numberBetween(0, 25),
            'coaching_hours_spent' => $this->faker->numberBetween(0, 5),
            'coach_rating' => $this->faker->numberBetween(0, 5)
        ];
    }
}
