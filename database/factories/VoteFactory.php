<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition()
    {
        return [
            'vote' => $this->faker->randomElement(['like', 'hate']),
            'user_id' => User::factory(),
            'movie_id' => Movie::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
