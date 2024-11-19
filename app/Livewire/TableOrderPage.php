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

    public function orderProduct(int $productId)
    {
        $quantity = $this->quantities[$productId];

        if ($quantity > 0) {
            $this->reservation->bill->products()->attach($productId, ['quantity' => $quantity]);

            // Reset quantity for the product
            $this->quantities[$productId] = 0;

            session()->flash('userMessage', 'Product toegevoegd aan de rekening!');
        } else {
            session()->flash('userMessage', 'Quantity must be greater than zero.');
        }
    }

    public function render()
    {
        return view('livewire.table-order-page');
    }
}
