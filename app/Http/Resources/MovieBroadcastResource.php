<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixin $id
 * @property mixin $movie_id
 * @property mixin $channel_nr
 * @property mixin $broadcasts_at
 * @property mixin $created_at
 * @property mixin $updated_at
 * @property MovieResource $movie
 */
class MovieBroadcastResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'movie_id' => $this->movie_id,
            'channel_nr' => $this->channel_nr,
            'broadcasts_at' => $this->broadcasts_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'movie' => new MovieResource($this->whenLoaded('movie')),
        ];
    }
}
