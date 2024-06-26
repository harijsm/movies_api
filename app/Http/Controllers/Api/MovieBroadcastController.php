<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Movie;
use App\Models\MovieBroadcast;
use App\Http\Resources\MovieBroadcastResource;
use App\Http\Resources\MovieResource;
use App\Http\Resources\MovieBroadcastCollection;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MovieBroadcastController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth:sanctum', except: ['index', 'show'])
        ];
    }

    /**
     * Return a list of all broadcasts airing now or in the future for single movie.
     *
     * @param  \App\Models\Movie  $movie
     * @return \App\Http\Resources\MovieBroadcastCollection
     */
    public function index(Movie $movie): MovieBroadcastCollection
    {
        $limit = request()->input('limit', 10);
        $broadcasts = $movie->broadcasts()->airingAndInFuture($movie["running_time"])->OrderBy('broadcasts_at')->paginate($limit);

        return new MovieBroadcastCollection($broadcasts, $movie);
    }

    /**
     * Store a new movie broadcast.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \App\Http\Resources\MovieBroadcastResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Movie $movie): MovieBroadcastResource
    {
        $data = $request->validate([
            'channel_nr' => 'required|numeric',
            'broadcasts_at' => 'required|date',
        ]);

        $maxLimit = $movie->broadcasts()->channelMovieBroadcastingDate($data['channel_nr'], $data['broadcasts_at'])->first();

        if ($maxLimit) {
            throw ValidationException::withMessages(['broadcasts_at' => 'Movie is already broadcasted at the same day on the same channel']);
        }

        $broadcast = $movie->broadcasts()->create($data);

        if(!$movie["premieres_at"] && $broadcast) {
            $movie->update(['premieres_at' => $data["broadcasts_at"]]);
        }

        return new MovieBroadcastResource($broadcast);
    }

    /**
     * Display the specified movie broadcast.
     *
     * @param  \App\Models\Movie  $movie
     * @param  \App\Models\MovieBroadcast  $broadcast
     * @return \App\Http\Resources\MovieBroadcastResource
     */
    public function show(Movie $movie, MovieBroadcast $broadcast): MovieBroadcastResource
    {
        return new MovieBroadcastResource($broadcast);
    }

    /**
     * Delete a movie broadcast.
     *
     * @param string $movie The movie identifier.
     * @param MovieBroadcast $broadcast The movie broadcast instance.
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $movie, MovieBroadcast $broadcast): \Illuminate\Http\Response
    {
        $broadcast->delete();

        return response(204);
    }
}
