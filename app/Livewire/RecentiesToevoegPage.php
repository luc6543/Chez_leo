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

    // Controleer of de gebruiker al een recensie heeft
    $existingReview = Review::where('user_id', Auth::id())->first();

    if ($existingReview) {
        // Als er al een recensie bestaat, toon een foutmelding
        session()->flash('error', 'Je hebt al een recensie geplaatst!');
        return;
    }

    // Controleer of er een reviewId is en werk de recensie bij
    if ($this->reviewId) {
        $review = Review::where('id', $this->reviewId)
                        ->where('user_id', Auth::id()) // Alleen recensies van de gebruiker
                        ->first();

        if ($review) {
            // Update de bestaande recensie
            $review->update([
                'review' => $this->review,
                'rating' => $this->rating,
            ]);
            session()->flash('message', 'Recensie succesvol bijgewerkt!');
        } else {
            session()->flash('error', 'Geen toegang om deze recensie te bewerken.');
        }
    } else {
        // Voeg een nieuwe recensie toe als er geen reviewId is
        Review::create([
            'user_id' => Auth::id(), // Ingelogde gebruiker
            'review' => $this->review, // Tekst van de review
            'rating' => $this->rating, // Rating van de review
        ]);
        session()->flash('message', 'Recensie succesvol toegevoegd!');
    }

    // Reset velden na opslaan
    $this->reset(['review', 'rating', 'reviewId']);

    // Redirect naar recensies overzicht
    return redirect('/recensies');
}

    public function editReview($reviewId, $data)
    {
        // Zoek de recensie op basis van het ID en de gebruiker
        $review = Review::where('id', $reviewId)
            ->where('user_id', Auth::id()) // Alleen recensies van de gebruiker
            ->first();
            
            if ($review) {
                // Werk de recensie bij met de nieuwe gegevens
                $review->update($data);
                session()->flash('message', 'Recensie succesvol bijgewerkt!');
            } else {
                session()->flash('error', 'Geen toegang om deze recensie te bewerken.');
            }
    }

    // Laat de pagina zien
    public function render()
    {
        return view('livewire.recenties-toevoeg-page');
    }
}
