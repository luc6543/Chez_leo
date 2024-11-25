<?php

namespace App\Livewire;

use App\Models\Review;
use Livewire\Component;

class AdminRecenties extends Component
{
    public $reviews;
    // public $approved;

    public function mount()
    {
      
        $this->reviews = Review::all();
    }
    
   

    public function render()
    {
        return view('livewire.admin-recenties', ['reviews' => $this->reviews]);
    }
    

    public function RecensieBevestiging($reviewId) {
        $review = Review::find($reviewId);

        if ($review) {
            $review->is_approved = !$review->is_approved;
            $review->save();

            $this->reviews = Review::all();
        }
    }

    public function verwijderRecensie($reviewId) {
        $review = Review::find($reviewId);

        if ($review) {
            $review->delete();

            $this->reviews = Review::all();
        }
    }
}