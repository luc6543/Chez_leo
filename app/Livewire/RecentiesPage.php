<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;

class RecentiesPage extends Component
{
    public function render()
    {
        $reviews = Review::with('user')->orderBy('created_at', 'desc')->get();

        return view('livewire.recenties-page', [
            'reviews' => $reviews,
        ]);
    }
}
