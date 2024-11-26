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
        return $this->belongsToMany(Reservation::class, 'reservation_table');
    }

    public function getCurrentReservation()
    {
        return $this->reservations()
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())->whereHas('bill', function ($query) {
                $query->where('paid', '!=', '1'); // Filter related bill records
            })
            ->first();
    }
}
