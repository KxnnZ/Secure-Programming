<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BookingSeat extends Model {
    protected $fillable = ['booking_id','seat_id','showtime_id'];
}