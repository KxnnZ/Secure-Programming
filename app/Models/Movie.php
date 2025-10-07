<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Movie extends Model
{
        protected $fillable = [
    'title','synopsis','release_date','end_date','poster_path','duration'
    ];

    protected $casts = [
    'release_date'=>'date',
    'end_date'=>'date',
    'duration'=>'integer',
    ];

    // URL poster
    public function getPosterUrlAttribute(): string
    {
        return $this->poster_path
            ? asset('storage/'.$this->poster_path)
            : 'https://via.placeholder.com/300x450?text=No+Poster';
    }

    //sedang tayang
    public function scopeNowShowing(Builder $q): Builder
    {
        $today = now()->toDateString();
        return $q->whereDate('release_date','<=',$today)
                 ->where(function ($x) use ($today) {
                     $x->whereNull('end_date')->orWhereDate('end_date','>=',$today);
                 });
    }

    //akan tayang
    public function scopeUpcoming(Builder $q): Builder
    {
        return $q->whereDate('release_date','>', now());
    }
}
