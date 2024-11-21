<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Reservation; // Assuming this is the reservation model
use Livewire\Component;

class TableOrderPage extends Component
{
    public $products;
    public $categories;
    public $groupedProducts;
    public $quantities; // Holds quantities for products
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

    public function orderProduct(int $productId)
    {
        if($this->reservation->bill->paid != true) {
            $quantity = $this->quantities[$productId];

            if ($quantity > 0) {
                $this->reservation->bill->products()->attach($productId, ['quantity' => $quantity]);

                // Reset quantity for the product
                $this->quantities[$productId] = 0;

                session()->flash('userMessage', 'Product toegevoegd aan de rekening!');
            } else {
                session()->flash('userMessage', 'Hoeveelheid moet meer zijn dan 0');
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
