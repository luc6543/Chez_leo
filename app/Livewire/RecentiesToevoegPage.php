<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class RecentiesToevoegPage extends Component
{
    public $review = ''; // Tekst voor de review
    public $rating = 0; // Rating voor de review. Standaard 0 (geen rating geselecteerd)

    protected $rules = [
        'review' => 'required|string|max:255', // Max aantal karakters in de review
        'rating' => 'required|integer|min:1|max:5', // Rating tussen 1 en 5
    ];

    // Methode om de rating in te stellen via een klik
    public function setRating($value)
    {
        $this->rating = $value;
    }

    // Voegt review toe
    public function addReview()
    {
        // Valideert eerst de uitvoering
        $this->validate();

        // Slaat review op in database
        Review::create([
            'user_id' => Auth::id(), // Ingelogde gebruiker
            'review' => $this->review, // Tekst van de review
            'rating' => $this->rating, // Rating van de review
        ]);

        // Reset velden na opslaan
        $this->reset(['review', 'rating']);

        // Succesbericht
       // session()->flash('message', 'Review is toegevoegd!');

        return redirect('/recensies');
    }

    // Laat de pagina zien
    public function render()
    {
        return view('livewire.recenties-toevoeg-page');
    }
}
