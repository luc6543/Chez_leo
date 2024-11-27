<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class RecentiesToevoegPage extends Component
{
    public $reviewId; // Id van de recensie
    public $review = ''; // Tekst voor de recensie
    public $rating = 0; // Rating voor de recensie. Standaard 0 (geen rating geselecteerd)

    protected $rules = [
        'review' => 'required|string|max:255', // Max aantal karakters in de recensie
        'rating' => 'required|integer|min:1|max:5', // Rating tussen 1 en 5
    ];

    // Methode om de beoordeling in te stellen via een klik
    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function mount($id = null) 
    {
        if($id)
        {
            $review = Review::findOrFail($id);

            $this->reviewId = $review->id;
            $this->review = $review->review;
            $this->rating = $review->rating;
        }
    }

    //Slaat de recensie op op
    public function saveReview()
    {
    
        // Valideert eerst de invoer
    $this->validate();

    if ($this->reviewId) {
        $this->updateReview(); // Bijwerken als er een reviewId is
    } else {
        $this->storeReview(); // Aanmaken als er geen reviewId is
    }

    // Reset velden na opslaan
    $this->reset(['review', 'rating']);

    // Redirect naar recensiespagina
    return redirect('/recensies');
    }

    public function storeReview()
    {
    // Maakt een nieuwe recensie aan
    Review::create([
        'user_id' => Auth::id(), // De ingelogde gebruiker
        'review' => $this->review, // Tekst van de recensie
        'rating' => $this->rating, // Beoordeling
    ]);

    session()->flash('message', 'Recensie is succesvol toegevoegd!');
    }

    public function updateReview()
    {
    // Werkt een bestaande recensie bij
    $review = Review::findOrFail($this->reviewId);

    $review->update([
        'review' => $this->review, // Bijgewerkte tekst
        'rating' => $this->rating, // Bijgewerkte beoordeling
    ]);

    session()->flash('message', 'Recensie is succesvol bijgewerkt!');
    }

    // Laat de pagina zien
    public function render()
    {
        return view('livewire.recenties-toevoeg-page');
    }
}
