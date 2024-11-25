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

        // Fetch all tables
        $this->tables = Table::all();

        // Fetch reservations for the current day
        $this->reservations = Reservation::whereDate('start_time', $date_time)
            ->orWhereDate('end_time', $date_time)
            ->get();
    }

    // Bijwerken van specifieke eigenschappen
    public function updated($propertyName, $value)
    {
        $this->$propertyName = $value;

        $this->fetchData();
    }
}
