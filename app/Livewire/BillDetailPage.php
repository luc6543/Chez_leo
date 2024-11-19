<?php

namespace App\Livewire;

use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BillDetailPage extends Component
{
    public $bill;
    public function render()
    {
        return view('livewire.bill-detail-page');
    }

    public function mount(Bill $bill){
        if( $bill->user->id != Auth::user()->id || !Auth::user()->hasRole('medewerker') || !Auth::user()->hasRole('admin') ) {
            abort(403,'Deze rekening is niet van u.');
        }
        $this->bill = $bill;
    }


}
