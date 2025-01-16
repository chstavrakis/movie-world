<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Store a newly created vote in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $movieId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $movieId)
    {
        $request->validate([
            'vote' => 'required|in:like,hate',
        ]);

        $movie = Movie::findOrFail($movieId);

        // Check if the user is trying to vote for their own movie
        if ($movie->user_id == Auth::id()) {
            return redirect()->back()->with('error', 'You cannot vote for your own movie.');
        }

        // Check if the user has already voted for this movie
        $existingVote = Vote::where('movie_id', $movieId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingVote) {
            // Update the existing vote
            $existingVote->vote = $request->vote;
            $existingVote->save();
        } else {
            // Create a new vote
            $vote = new Vote();
            $vote->movie_id = $movieId;
            $vote->user_id = Auth::id();
            $vote->vote = $request->vote;
            $vote->save();
        }

        return redirect()->back()->with('success', 'Your vote has been recorded.');
    }

    /**
     * Remove the specified vote from storage.
     *
     * @param  int  $movieId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($movieId)
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
