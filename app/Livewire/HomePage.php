<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;


class HomePage extends Component
{
    public $products;
    public $category = "Lunch";
    public function mount(){
        $this->products = Product::Where("category", "Lunch")->get();
    }
    public function render()
    {
        return view('livewire.home-page');
    }
    public function filter($category){
        $this->category = $category;
       $this->products = Product::Where("category", $category)->get();
       sleep(0.5);
    }
}