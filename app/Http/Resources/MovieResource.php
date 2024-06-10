<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixin $id
 * @property mixin $title
 * @property mixin $rating
 * @property mixin $age_restriction
 * @property mixin $description
 * @property mixin $premieres_at
 * @property mixin $created_at
 * @property mixin $updated_at
 */
class MovieResource extends JsonResource
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
            'title' => $this->title,
            'rating' => $this->rating,
            'age_restriction' => $this->age_restriction,
            'description' => $this->description,
            'premieres_at' => $this->premieres_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
