<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableReservation extends Model
{
    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'table_reservation';

    // Define the fillable attributes
    protected $fillable = [
        'reservation_id',
        'table_id',
    ];

    // Define relationships if necessary
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}