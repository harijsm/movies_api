<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Movie;
use App\Models\MovieBroadcast;
use App\Http\Resources\MovieBroadcastResource;

class MovieBroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Movie $movie) : AnonymousResourceCollection
    {
        $limit = request()->input('limit', 10);
        $broadcasts = $movie->broadcasts()->airingAndInFuture($movie->running_time)->OrderBy('broadcasts_at')->paginate($limit);
        $broadcasts->load('movie');
        
        return MovieBroadcastResource::collection($broadcasts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Movie $movie) : MovieBroadcastResource
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

        if(!$movie->premieres_at && $broadcast) {
            $movie->update(['premieres_at' => $broadcast->broadcasts_at]);
        }

        return new MovieBroadcastResource($broadcast);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie, MovieBroadcast $broadcast) : MovieBroadcastResource
    {
        return new MovieBroadcastResource($broadcast);
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
    public function destroy(string $movie, MovieBroadcast $broadcast) : \Illuminate\Http\Response
    {
        $broadcast->delete();

        return response(204);
    }
}
