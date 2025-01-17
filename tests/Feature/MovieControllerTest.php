<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    use WithoutEvents;

    public function test_list_movies(): void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('movies.list'));

        $response->assertStatus(200);
        $response->assertSee($movie->title);
    }

    public function test_list_movies_with_user_vote(): void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->withUserVote($user, 'like')->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('movies.list'));

        $response->assertStatus(200);
        $response->assertSee($movie->title);
        $response->assertSee('1 likes');
    }
}
