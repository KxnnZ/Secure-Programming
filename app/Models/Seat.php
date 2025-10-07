<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Seat extends Model {
    protected $fillable = ['theater_id','code','row','col','type'];
    public function theater(){ return $this->belongsTo(Theater::class); }
}
