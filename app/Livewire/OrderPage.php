<?php

namespace App\Livewire;

use App\Models\Table;
use Carbon\Carbon;
use Livewire\Component;

class OrderPage extends Component
{
    public $tables;
    public function render()
    {
        return view('livewire.order-page');
    }

    public function refresh() {
        $this->tables = Table::all();
    }

    public function mount() {
        $this->refresh();
    }
    public function createBill(Table $table) {
        if($table->getCurrentReservation()) {
            $this->redirect('/admin/reservation/'.$table->getCurrentReservation()->id);
        }
        else {
            $reservation = $table->reservations()->create([
                'table_id' => $table->id,
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addHours(3),
            ]);
            $this->redirect('/admin/reservation/'.$reservation->id);
        }
    }
}
