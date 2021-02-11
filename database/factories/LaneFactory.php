<?php

namespace Database\Factories;

use App\Models\Lane;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LaneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lane::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'image' => Str::random(10)
        ];
    }
}
