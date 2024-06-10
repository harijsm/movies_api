<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Movie;

class MovieBroadcastCollection extends ResourceCollection
{
    public Movie $movie;

    public function __construct($resource, Movie $movie)
    {
        parent::__construct($resource);
        $this->movie = $movie;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'movie' => $this->movie,
            'data' => $this->collection,
        ];
    }
}
