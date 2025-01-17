<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'user_id' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }


    public function withUserVote(User $user, string $voteType)
    {
        return $this->afterCreating(function (Movie $movie) use ($user, $voteType) {
            Vote::factory()->create([
                'user_id' => $user->id,
                'movie_id' => $movie->id,
                'vote' => $voteType,
            ]);
        });
    }
}
