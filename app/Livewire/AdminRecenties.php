<?php

namespace App\Livewire;

use App\Models\Review;
use Livewire\Component;

class AdminRecenties extends Component
{
    public $reviews;
    
    public function render()
    {
        $this->reviews = Review::all();
        return view('livewire.admin-recenties', ['reviews' => $this->reviews]);
    }
    
}