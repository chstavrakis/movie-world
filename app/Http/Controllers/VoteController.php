<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Vote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Store a newly created vote in storage.
     *
     * @param Request $request
     * @param int $movieId
     * @return RedirectResponse
     */
    public function store(Request $request, int $movieId): RedirectResponse
    {
        $request->validate([
            'vote' => 'required|in:like,hate',
        ]);

        $movie = Movie::findOrFail($movieId);

        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('movies.list')->with('error', 'You must be logged in to vote.');
        }

        // Ensure the user is not voting for their own movie
        if (Auth::id() === $movie->user_id) {
            return redirect()->route('movies.list')->with('error', 'You cannot vote for your own movie.');
        }

        // Check if the user has already voted for this movie
        $existingVote = Vote::where('user_id', Auth::id())->where('movie_id', $movieId)->first();

        if ($existingVote) {
            // If the user votes the same vote again, unvote
            if ($existingVote->vote === $request->input('vote')) {
                $existingVote->delete();
                return redirect()->route('movies.list')->with('success', 'Your vote has been removed.');
            } else {
                // Update the vote if it's different
                $existingVote->vote = $request->input('vote');
                $existingVote->save();
                return redirect()->route('movies.list')->with('success', 'Your vote has been updated.');
            }
        }

        // Create a new vote
        $vote = new Vote();
        $vote->user_id = Auth::id();
        $vote->movie_id = $movieId;
        $vote->vote = $request->input('vote');
        $vote->save();

        return redirect()->route('movies.list')->with('success', 'Your vote has been recorded.');
    }

    /**
     * Remove the specified vote from storage.
     *
     * @param int $movieId
     * @return RedirectResponse
     */
    public function destroy(int $movieId): RedirectResponse
    {
        $vote = Vote::where('movie_id', $movieId)
            ->where('user_id', Auth::id())
            ->first();

        if ($vote) {
            $vote->delete();
            return redirect()->back()->with('success', 'Your vote has been removed.');
        }

        return redirect()->back()->with('error', 'You have not voted for this movie.');
    }
}
