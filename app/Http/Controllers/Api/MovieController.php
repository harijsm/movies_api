<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Movie;
use App\Http\Resources\MovieResource;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : MovieResource
    {
        $title = $request->input('title');
        $movies = Movie::when(
            $title,
            fn($query, $title) => $query->title($title)
        );

        return new MovieResource($movies->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : MovieResource
    {
        $movie = Movie::create(
            $request->validate([
                'title' => 'required|max:100',
                'rating' => 'required|numeric|between:0.0,10.0',
                'age_restriction' => 'in:'.implode(',', Movie::$validAgeRestrictions),
                'description' => 'required|max:500',
                'premieres_at' => 'required|date',
            ])
        );

        return new MovieResource($movie);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie) : MovieResource
    {
        $movie->load('broadcasts');
        return new MovieResource($movie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie) : \Illuminate\Http\Response
    {
        $movie->delete();

        return response(204);
    }
}
