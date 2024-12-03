<?php

namespace App\Livewire;

use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BillDetailPage extends Component
{
    public $bill;
    public bool $paid;
    public function render()
    {
        return view('livewire.bill-detail-page');
    }

    public function updated($propertyName,$value) {
        $this->$propertyName = $value;

        $this->bill->update([
            'paid' => $this->paid
        ]);


    }

    public function mount(Bill $bill){
        if($bill->user) {
            if ($bill->user->id != Auth::user()->id && !Auth::user()->hasRole('medewerker') || !Auth::user()->hasRole('admin')) {
                abort(403, 'Deze rekening is niet van u.');
            }
        }
        elseif(!Auth::user()->hasRole('medewerker')) {
            abort(404, 'Deze Rekening niet gevonden.');
        }
        $this->bill = $bill;
        $this->paid = $bill->paid;
    }


}
