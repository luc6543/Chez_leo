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
    public function tables()
    {
        return $this->belongsToMany(Table::class, 'reservation_tables');
    }

    public static function getCurrentReservations()
    {
        return Reservation::where('start_time', '<=', now())->where('end_time', '>=', now())->whereHas('bill', function ($query) {
            $query->where('paid', '!=', '1'); // Filter related bill records
        })->get();
    }
    public function bill()
    {
        return $this->hasOne(Bill::class);
    }

    public static function calculateEndTime($startTime)
    {

        $timeRanges = [
            3 => [17, 22], // Wednesday
            4 => [12, 22], // Thursday
            5 => [12, 23], // Friday
            6 => [12, 23], // Saturday
            0 => [12, 23]  // Sunday
        ];
        $dayOfWeek = $startTime->dayOfWeek;
        $hour = $startTime->hour;

        if ($hour >= 12 && $hour < 18) {
            // Afternoon: reservation lasts 1.5 hours
            $endTime = $startTime->copy()->addHours(1)->addMinutes(30);
        } else {
            // Evening: reservation lasts 3 hours
            $endTime = $startTime->copy()->addHours(3);
        }

        if (isset($timeRanges[$dayOfWeek])) {
            $closingHour = $timeRanges[$dayOfWeek][1];
            $closingTime = $startTime->copy()->setTime($closingHour, 0);

            if ($endTime->greaterThan($closingTime)) {
                $endTime = $closingTime;
            }
        }
        return $endTime;
    }
}
