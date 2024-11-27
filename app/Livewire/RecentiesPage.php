<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;

class RecentiesPage extends Component
{
    public function render()
{
    $reviews = Review::with('user')->orderBy('created_at', 'desc')->get();
    $totalReviews = $reviews->count();

    $starCount = [
        5 => $reviews->where('rating', 5)->count(),
        4 => $reviews->where('rating', 4)->count(),
        3 => $reviews->where('rating', 3)->count(),
        2 => $reviews->where('rating', 2)->count(),
        1 => $reviews->where('rating', 1)->count(),
    ];

    $percentages = $totalReviews > 0 ? array_map(function ($count) use ($totalReviews) {
        return round(($count / $totalReviews) * 100, 0);
    }, $starCount) : [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

    return view('livewire.recenties-page', [
        'reviews' => $reviews,
        'percentages' => $percentages,
    ]);
}

}
