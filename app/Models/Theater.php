<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Theater extends Model {
    protected $fillable = ['name','rows','cols'];
    public function seats(){ return $this->hasMany(Seat::class); }
}
