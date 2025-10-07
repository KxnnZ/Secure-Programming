<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Showtime extends Model {
    protected $fillable = ['movie_id','theater_id','start_at','price'];
    protected $casts = ['start_at'=>'datetime'];
    public function movie(){ return $this->belongsTo(\App\Models\Movie::class); }
    public function theater(){ return $this->belongsTo(\App\Models\Theater::class); }
    public function bookings(){ return $this->hasMany(\App\Models\Booking::class); }
}