<?php

namespace App\Livewire;

use App\Models\Table;
use Carbon\Carbon;
use Livewire\Component;

class OrderPage extends Component
{
    public $groupedReservations;

    public function render()
    {
        return view('livewire.order-page');
    }

    public function refresh()
    {
        $tables = Table::with('reservations.bill.user')->get();

        $this->groupedReservations = $tables->groupBy(function ($table) {
            $currentReservation = $table->getCurrentReservation();
            return $currentReservation ? $currentReservation->id : 'table_' . $table->id;
        })->map(function ($group, $key) {
            $reservation = $group->first()->getCurrentReservation();
            return [
                'reservation' => $reservation,
                'tables' => $group,
            ];
        });
    }


    public function mount()
    {
        $this->refresh();
    }

    public function createBill(Table $table)
    {
        if ($table->getCurrentReservation()) {
            $this->redirect('/admin/reservation/' . $table->getCurrentReservation()->id);
        } else {
            $reservation = $table->reservations()->create([
                'table_id' => $table->id,
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addHours(3),
            ]);
            $this->redirect('/admin/reservation/' . $reservation->id);
        }
    }
}
