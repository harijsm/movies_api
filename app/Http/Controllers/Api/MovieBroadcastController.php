<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\MovieBroadcast;
use App\Http\Resources\MovieBroadcastResource;

class MovieBroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Movie $movie) : MovieBroadcastResource
    {
        $broadcasts = $movie->broadcasts()->airingAndInFuture()->OrderBy('broadcasts_at')->paginate(10);
        
        return new MovieBroadcastResource($broadcasts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Movie $movie)
    {
        $broadcast = $movie->broadcasts()->create(
            $request->validate([
                'channel_nr' => 'required|numeric',
                'broadcasts_at' => 'required|date',
            ])
        );

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
