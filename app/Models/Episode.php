<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['number'];

    public function seasons()
    {
        return $this->belongsTo(Season::class);
    }

    public function watchProgress()
    {
        return $this->hasMany(WatchProgress::class);
    }

    public function getProgressForUser($userId)
    {
        return $this->watchProgress()->where('user_id', $userId)->first();
    }

    public function isWatchedByUser($userId)
    {
        return $this->watchProgress()
            ->where('user_id', $userId)
            ->where('status', 'watched')
            ->exists();
    }

    public function isInProgressByUser($userId)
    {
        return $this->watchProgress()
            ->where('user_id', $userId)
            ->where('status', 'in_progress')
            ->exists();
    }
}
