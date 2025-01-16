<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    /**
     * Get the user that owns the movie.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the votes for the movie.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
