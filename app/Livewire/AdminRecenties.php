<?php

namespace App\Livewire;

use App\Models\Review;
use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;
use Livewire\Component;
use OpenAI;

class AdminRecenties extends Component
{
    public $reviews;
    // public $approved;
    public $AIGenerated;

    public function mount()
    {

        $this->reviews = Review::all();
    }



    public function render()
    {
        return view('livewire.admin-recenties', ['reviews' => $this->reviews]);
    }

    public function getVerbeterPunten() {
        $reviews = 'review: '.$this->reviews->pluck('review')->implode("\n");

        $client = new Client(env('GEMINI_API'));
        $response = $client->geminiPro()->generateContent(
            new TextPart('reageer op het volgende met een li in html eromheen: op mijn website staan reviews over mijn restaurant helaas zijn sommige hiervan aanstootgevend maar zou jij mij mogelijke verbeterpunten kunnen geven voor mijn restaurant aangeleid door de volgende reviews laat ook zien op basis van welke specifieke texten deze zijn bedacht: '.$reviews),
        );

        $this->AIGenerated = $response->text();
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
