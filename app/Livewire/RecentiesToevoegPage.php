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

    // Voegt review toe
    public function saveReview()
{
    // Valideer de invoer
    $this->validate();

    // Als reviewId bestaat, werk dan de recensie bij
    if ($this->reviewId) {
        $this->updateReview();
    } else {
        // Als geen reviewId bestaat, voeg een nieuwe recensie toe
        $this->createReview();
    }
}

public function createReview()
{
    // Controleer of de gebruiker al een recensie heeft
    if ($this->checkIfReviewExists()) {
        session()->flash('error', 'Je hebt al een recensie geplaatst!');
        return;
    }

    // Voeg de nieuwe recensie toe
    Review::create([
        'user_id' => Auth::id(),
        'review' => $this->review,
        'rating' => $this->rating,
    ]);

    session()->flash('message', 'Recensie succesvol toegevoegd!');
    return redirect('/recensies');
}

public function updateReview()
{
    // Zoek de recensie die moet worden bijgewerkt
    $review = Review::where('id', $this->reviewId)
                    ->where('user_id', Auth::id()) // Zorg ervoor dat het de ingelogde gebruiker is
                    ->first();

    if ($review) {
        // Werk de bestaande recensie bij
        $review->update([
            'review' => $this->review,
            'rating' => $this->rating,
        ]);

        session()->flash('message', 'Recensie succesvol bijgewerkt!');
        return redirect('/recensies');
    } else {
        // Als de recensie niet bestaat, toon dan een foutmelding
        session()->flash('error', 'Geen toegang om deze recensie bij te werken.');
    }
}

public function checkIfReviewExists()
{
    // Controleer of de gebruiker al een recensie heeft
    return Review::where('user_id', Auth::id())->exists();
}


    // Laat de pagina zien
    public function render()
    {
        return view('livewire.recenties-toevoeg-page');
    }
}
