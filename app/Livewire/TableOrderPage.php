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
        $this->reservation = $reservation;

        // Fetch all products
        $this->products = Product::all()->groupBy('category')->toArray();

        foreach($this->products as $category => $products){
            foreach($products as $product){
                $this->quantities[$product['id']] = 0; // add quantity and product to quantities array.
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
