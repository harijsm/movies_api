<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class MovieBroadcast extends Model
{
    use HasFactory;

    protected $fillable = ['channel_nr', 'broadcasts_at'];

    public function movie() : BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function scopeAiringAndInFuture(Builder $query): Builder
    {
        return $query->where('broadcasts_at', '>=', now());
    }
}
