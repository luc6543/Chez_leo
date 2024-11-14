<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    public function bills(){
        return $this->hasMany(Bill::class);
    }
    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
}