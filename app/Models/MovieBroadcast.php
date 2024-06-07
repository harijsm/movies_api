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

    /**
     * Scope a query to only include movie broadcasts that are airing and in the future.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $running_time
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAiringAndInFuture(Builder $query, int $running_time = 0): Builder
    {
        return $query->where('broadcasts_at', '>=', now()->addMinute(-$running_time));
    }

    /**
     * Scope a query to only include movie broadcasts that are airing on the same day on the same channel.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $channel
     * @param  string  $datetime
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeChannelMovieBroadcastingDate(Builder $query, string $channel, string $datetime): Builder
    {
        return $query->where('channel_nr', $channel)->whereDate('broadcasts_at', date("Y-m-d", strtotime($datetime)));
    }
}
