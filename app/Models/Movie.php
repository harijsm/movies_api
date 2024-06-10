<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Movie extends Model
{
    use HasFactory;

    public static array $validAgeRestrictions = [0, 7, 12, 16];

    protected $fillable = ['title', 'rating', 'age_restriction', 'description', 'premieres_at', 'running_time'];


    public function broadcasts(): HasMany
    {
        return $this->hasMany(MovieBroadcast::class);
    }

    /**
     * Scope a query to filter movies by title.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $title
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }
}
