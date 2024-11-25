<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Reservation; // Assuming this is the reservation model
use Livewire\Component;

class TableOrderPage extends Component
{
    public $products;
    public $quantities;
    public $reservation;

    public function mount(Reservation $reservation)
    {
        $lunchStart = 11;
        $lunchEnd = 17;

        $this->reservation = $reservation;

        $currentHour = now()->hour;
        if($currentHour >= $lunchStart && $currentHour < $lunchEnd) {
            $this->products = Product::WhereNot('category', 'Diner')->WhereNot('category', 'dessert')->get()
                ->groupBy('category')
                ->toArray();
        }
        else {
            $this->products = Product::WhereNot('category', 'Lunch')
                ->groupBy('category')
                ->toArray();
        }

        $this->quantities = [];

        foreach ($this->products as $category => $products) {
            foreach ($products as $product) {
                $this->quantities[$product['id']] = 0;
            }
        }
    }

    public function addQuantity(int $productId)
    {
        $this->quantities[$productId] += 1;
    }

    public function removeQuantity(int $productId)
    {
        if ($this->quantities[$productId] > 0) {
            $this->quantities[$productId] -= 1;
        }
    }

    public function order()
    {
        if ($this->reservation->bill->paid != true) {

            // variable for added something or not alert
            $addedSomething = false;
            foreach ($this->quantities as $product => $quantity) {
                if ($quantity > 0) {
                    $addedSomething = true;
                    $this->reservation->bill->products()->attach($product, ['quantity' => $quantity]);

                    // Reset quantity for the product
                    $this->quantities[$product] = 0;
                    session()->flash('userMessage','Producten toegevoegd aan rekening.');
                }
            }
            if (!$addedSomething) {
                session()->flash('userMessage','Geen producten toegevoegd.');
            }
        }
    }


    public function billPaid() {
        $this->reservation->bill->paid = true;
        $this->reservation->bill->save();
        $this->redirect('/admin/order');
        session()->flash('userMessage', 'Rekening betaald.');
    }

    public function render()
    {
        return view('livewire.table-order-page');
    }
}
