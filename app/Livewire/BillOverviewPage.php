<?php

namespace App\Livewire;

use App\Models\Bill;
use Livewire\Component;

class BillOverviewPage extends Component
{
    public $bills;
    public function render()
    {
        return view('livewire.bill-overview-page');
    }

    public function refresh() {
        $this->bills = Bill::all();
    }

    public function mount() {
        $this->refresh();
    }


}
