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
        'special_request',
        'start_time',
        'end_time',
        'paid',
        'email_send',
        'present',
        'active',
        'people',
        'guest_name',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public static function getCurrentReservations() {
        return Reservation::where('start_time', '<=', now())->where('end_time', '>=', now())->whereHas('bill', function ($query) {
                $query->where('paid', '!=', '1'); // Filter related bill records
            })->get();
    }
    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
}
