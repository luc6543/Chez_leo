<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{

    protected $fillable = [
        'chairs',
        'table_number',
    ];

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}