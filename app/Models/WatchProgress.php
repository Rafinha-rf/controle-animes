<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchProgress extends Model
{
    use HasFactory;

    protected $table = 'watch_progress';

    protected $fillable = [
        'user_id',
        'episode_id',
        'status',
        'watched_at',
        'current_time'
    ];

    protected $casts = [
        'watched_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }

    public function markAsWatched()
    {
        $this->update([
            'status' => 'watched',
            'watched_at' => now(),
            'current_time' => null
        ]);
    }

    public function markAsInProgress($currentTime)
    {
        $this->update([
            'status' => 'in_progress',
            'current_time' => $currentTime
        ]);
    }

    public function markAsNotWatched()
    {
        $this->update([
            'status' => 'not_watched',
            'watched_at' => null,
            'current_time' => null
        ]);
    }
} 