<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Movie;
use App\Http\Resources\MovieResource;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovieController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth:sanctum', except: ['index'])
        ];
    }

    /**
     * Display a list of all Movies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $title = $request->input('title');
        $limit = $request->input('limit', 10);
        $movies = Movie::query()->when(
            $title,
            fn ($query, $title) => $query->title($title)
        );

        return MovieResource::collection($movies->latest()->paginate($limit));
    }

    /**
     * Store a newly created movie in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\MovieResource
     */
    public function store(Request $request): MovieResource
    {
        $movie = Movie::query()->create(
            $request->validate([
                'title' => 'required|max:100',
                'rating' => 'required|numeric|between:0.0,10.0',
                'age_restriction' => 'in:'.implode(',', Movie::$validAgeRestrictions),
                'description' => 'required|max:500',
                'premieres_at' => 'date',
            ])
        );

        return new MovieResource($movie);
    }

    /**
     * Delete a movie.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie): \Illuminate\Http\Response
    {
        $movie->delete();

        return response(204);
    }
}
