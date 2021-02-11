<?php

namespace Database\Factories;

use App\Models\UserLane;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserLaneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserLane::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigit,
            'lane_id' => $this->faker->randomDigit
        ];
    }
}
