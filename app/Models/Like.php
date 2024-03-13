<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Like extends Model
{

    protected $fillable = ['movie_id', 'movie_title', 'movie_poster', 'movie_rating', 'user_id'];

    public function like(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
