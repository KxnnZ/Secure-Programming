<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Booking extends Model {
    protected $fillable = ['user_id','showtime_id','total_price','status','booked_at'];
    protected $casts = ['booked_at'=>'datetime'];
    public function seats(){ return $this->hasMany(BookingSeat::class); }
}