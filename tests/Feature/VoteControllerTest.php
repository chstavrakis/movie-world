<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class VoteControllerTest extends TestCase
{
    use WithoutEvents;

    public function test_store_vote(): void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $response = $this->actingAs($user)->post(route('movies.vote', $movie->id), [
            'vote' => 'like',
        ]);

        $response->assertRedirect(route('movies.list'));
        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'vote' => 'like',
        ]);
    }

    public function test_unvote(): void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        Vote::factory()->create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'vote' => 'like',
        ]);

        $response = $this->actingAs($user)->post(route('movies.vote', $movie->id), [
            'vote' => 'like',
        ]);

        $response->assertRedirect(route('movies.list'));
        $this->assertDatabaseMissing('votes', [
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'vote' => 'like',
        ]);
    }

    public function test_update_vote(): void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        Vote::factory()->create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'vote' => 'like',
        ]);

        $response = $this->actingAs($user)->post(route('movies.vote', $movie->id), [
            'vote' => 'hate',
        ]);

        $response->assertRedirect(route('movies.list'));
        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'vote' => 'hate',
        ]);
    }
}
