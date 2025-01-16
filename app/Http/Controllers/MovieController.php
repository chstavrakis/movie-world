<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    /**
     * Display a listing of the movies.
     *
     * @return \Illuminate\View\View
     */
    public function list(Request $request)
    {
        $sort = $request->query('sort', '');

        $movies = Movie::with('user')
            ->withCount(['votes as likes_count' => function ($query) {
                $query->where('vote', 'like');
            }])
            ->withCount(['votes as hates_count' => function ($query) {
                $query->where('vote', 'hate');
            }]);

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

        $movies = $movies->get();

        return view('movies.list', compact('movies', 'sort'));
    }

    /**
     * Show the form for creating a new movie.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('movies.create');
    }

    /**
     * Store a newly created movie in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $movie = new Movie();
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->user_id = Auth::id();
        $movie->save();

        return redirect()->route('movies.list')->with('success', 'Movie added successfully.');
    }
}
