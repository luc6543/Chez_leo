<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Table;
use App\Models\Reservation;

class ReservedTableViewPage extends Component
{
    public $tables;
    public $reservations;
    public $date_time;

    public function render()
    {
        $this->fetchData();

        return view('livewire.reserved-table-view-page');
    }

    public function fetchData()
    {
        // Get the date selected or the current date
        $date_time = $this->date_time ? Carbon::parse($this->date_time) : Carbon::now();
        $date = $date_time->format('Y-m-d');

        // Fetch all tables
        $this->tables = Table::all();

        // Fetch reservations that overlap with the selected date
        $this->reservations = Reservation::where(function ($query) use ($date) {
            $query->whereDate('start_time', '<=', $date)
                ->whereDate('end_time', '>=', $date);
        })->get();
    }

    // Bijwerken van specifieke eigenschappen
    public function updated($propertyName, $value)
    {
        $this->$propertyName = $value;

        $this->fetchData();
    }
}
