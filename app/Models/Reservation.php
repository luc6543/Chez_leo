<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table_id',
        'start_time',
        'end_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
