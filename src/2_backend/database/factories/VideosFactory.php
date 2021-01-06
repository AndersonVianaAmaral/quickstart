<?php

namespace Database\Factories;

use App\Models\Videos;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Videos::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rating = Videos::RATING_LIST[array_rand(Videos::RATING_LIST)];
        return [
            'title' => "videos title",
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
            'year_launched' => 2019,
            'opened' => false,
            'rating' => $rating,
            'duration' => 120
        ];
    }
}
