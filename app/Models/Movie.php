<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Movie extends Model
{
    use HasFactory;

    public static $validAgeRestrictions = [0, 7, 12, 16];

    protected $fillable = ['title', 'rating', 'age_restriction', 'description', 'premieres_at'];

    public function broadcasts() : HasMany
    {
        return $this->hasMany(MovieBroadcast::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }
}
