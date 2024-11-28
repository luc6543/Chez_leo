<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationTable extends Model
{
    protected $table = 'reservation_tables';

    protected $fillable = [
        'reservation_id',
        'table_id',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public static function getUsedTableIds($reservationId, $startTime, $endTime)
    {
        return self::join('reservations', 'reservation_tables.reservation_id', '=', 'reservations.id')
            ->where('reservations.id', '!=', $reservationId) // Exclude the current reservation being edited
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime) {
                    $query->where('reservations.start_time', '<', $startTime)
                        ->where('reservations.end_time', '>', $startTime);
                })->orWhere(function ($query) use ($endTime) {
                    $query->where('reservations.start_time', '<', $endTime)
                        ->where('reservations.end_time', '>', $endTime);
                })->orWhere(function ($query) use ($startTime, $endTime) {
                    $query->where('reservations.start_time', '>=', $startTime)
                        ->where('reservations.end_time', '<=', $endTime);
                });
            })
            ->pluck('reservation_tables.table_id')
            ->toArray();
    }
}