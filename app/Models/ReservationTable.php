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
}