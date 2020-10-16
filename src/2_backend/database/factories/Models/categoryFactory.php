<?php

namespace Database\Factories\Models;

use App\Models\Models\category;
use Illuminate\Database\Eloquent\Factories\Factory;

class categoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $faker->colorName,
            'description' => rand(1,10) % 2 == 0 ? $faker->setence() : null
        ];
    }
}
