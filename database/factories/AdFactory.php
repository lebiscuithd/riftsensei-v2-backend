<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $hourly_rate = $this->faker->numberBetween(1 , 20);
        $duration = $this->faker->numberBetween(1, 5);
        $total_price = $hourly_rate * $duration;
        return [
            'coach_id'=> User::all()->random()->id,
            'coaching_date' => $this->faker->dateTimeBetween($startDate = '+4 days', $endDate = '+1 year', $timezone = null),
            'description' => $this->faker->text(50),
            'status' => $this->faker->randomElement(['available' ,'pending', 'finished', 'rated']),
            'ad_rating' => $this->faker->numberBetween(0, 5),
            'duration' => $duration,
            'hourly_rate' => $hourly_rate,
            'student_id' => User::all()->random()->id,
            'comments' => $this->faker->text(50),
            'total_price' => $total_price
        ];
    }
}
