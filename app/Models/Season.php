<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    use HasFactory;
    protected $fillable = ['number'];

    public function animes()
    {
        return $this->belongsTo(Anime::class);
    }

    public function episodes()
    {
        return $this->HasMany(Episode::class);
    }
}
