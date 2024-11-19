<?php

namespace App\Livewire;

use App\Models\Reservation;
use Carbon\Carbon;
use Livewire\Component;

class OrderPage extends Component
{
    public $reservations;
    public function render()
    {
        return view('livewire.order-page');
    }

    public function refresh() {
        $this->reservations = Reservation::where('start_time', '>=', Carbon::today())
            ->where('start_time', '<', Carbon::tomorrow())
            ->whereHas('bill', function ($query) {
                $query->where('paid', '!=', '1'); // Filter related bill records
            })
            ->get();
    }

    public function mount() {
        $this->reservations = Reservation::where('start_time', '>=', Carbon::today())
            ->where('start_time', '<', Carbon::tomorrow())
            ->whereHas('bill', function ($query) {
                $query->where('paid', '!=', '1'); // Filter related bill records
            })
            ->get();

    }
}
