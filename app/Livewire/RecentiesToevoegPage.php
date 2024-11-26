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

    // Slaat de recensie op
    public function saveReview()
    {
        // Valideert eerst de uitvoering
        $this->validate();

        if($this->reviewId) {
            // Werkt de recensie bij
            $review = Review::findOrFail($this->reviewId);
            $review->update([
                'review' => $this->review,
                'rating' => $this->rating,
            ]);

            session()->flash('message', 'Recensie is bijgewerkt!');
        } else {
            // Maakt nieuwe recensie aan
            Review::create([
                'user_id' => Auth::id(), // Ingelogde gebruiker
                'review' => $this->review, // Tekst van de recensie
                'rating' => $this->rating, // Beoordeling van de recensie
            ]);

            session()->flash('message', 'Recensie is toegevoegd!');
        }
        
        // Reset velden na opslaan
        $this->reset(['review', 'rating']);

        // Succesbericht
       // session()->flash('message', 'Recensie is toegevoegd!');

        return redirect('/recensies');
    }

    // Laat de pagina zien
    public function render()
    {
        return view('livewire.recenties-toevoeg-page');
    }
}
