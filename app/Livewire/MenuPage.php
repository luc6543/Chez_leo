<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class MenuPage extends Component
{
    public $products;
    public $lunch;
    public $diner;
    public $dessert;
    public $drank;
    public $category = "Lunch";
    public function render()
    {
        return view('livewire.menu-page');
    }
    public function mount(){
        $this->lunch = Product::Where("category", "Lunch")->get();
        $this->products = $this->lunch;
        $this->diner = Product::Where("category", "Diner")->get();
        $this->dessert = Product::Where("category", "Dessert")->get();
        $this->drank = Product::Where("category", "Drank")->get();
    }
    public function filter($category){
        $this->category = $category;
        $this->products = Product::Where("category", $category)->get();
    }
}
