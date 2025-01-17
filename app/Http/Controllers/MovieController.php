<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MovieController extends Controller
{
    /**
     * Display a listing of the movies.
     *
     * @param Request $request
     * @return View
     */
    public function list(Request $request): View
    {
        // Get the sort parameter from the query string
        $sort = $request->query('sort', '');

        // Get all movies with the user who created them
        $movies = Movie::with('user')
            ->withCount(['votes as likes_count' => function ($query) {
                $query->where('vote', 'like');
            }])
            ->withCount(['votes as hates_count' => function ($query) {
                $query->where('vote', 'hate');
            }]);

        // Sort the movies
        switch ($sort) {
            case 'likes':
                $movies->orderBy('likes_count', 'desc');
                break;
            case 'hates':
                $movies->orderBy('hates_count', 'desc');
                break;
            case 'dates':
            default:
                $movies->orderBy('created_at', 'desc');
                break;
        }

        // Get the movies
        $movies = $movies->get();

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Add the user's vote to each movie
        foreach ($movies as $movie) {
            $userVote = $movie->votes()->where('user_id', $userId)->first();
            $movie->user_vote = $userVote ? $userVote->vote : null;
        }

        return view('movies.list', compact('movies', 'sort'));
    }

    /**
     * Show the form for creating a new movie.
     *
     * @return View
     */
    public function create(): View
    {
        return view('movies.create');
    }

    /**
     * Store a newly created movie in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $movie = new Movie([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);
        $movie->save();

        return redirect()->route('movies.list')->with('success', 'Movie added successfully.');
    }
}
