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
        try {
            $this->AIGenerated = '';

            $reviews = 'review: ' . $this->reviews->pluck('review')->implode("\n");

            $reviews = 'reageer op het volgende met een li in html eromheen: op mijn website staan reviews over mijn restaurant helaas zijn sommige hiervan aanstootgevend maar zou jij mij mogelijke verbeterpunten kunnen geven voor mijn restaurant aangeleid door de volgende reviews laat ook zien op basis van welke specifieke texten deze zijn bedacht: ' . $reviews;
            $wordLimit = 100; // Set the word limit to 20 million.
            $wordsArray = explode(' ', $reviews); // Split the string into an array of words.
            $limitedWordsArray = array_slice($wordsArray, 0, $wordLimit); // Take only the first $wordLimit words.
            $reviews = implode(' ', $limitedWordsArray); // Rebuild the string from the sliced array.

            $client = new Client(env('GEMINI_API'));
            $response = $client->geminiPro()->generateContent(
                new TextPart($reviews),
            );

            $this->AIGenerated = $response->text();
        }
        catch (\Exception $e) {
            $this->AIGenerated = "Er is een rate limit op het ophalen van verbeter punten probeer het over een kleine minuut nog eens.";
        }
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
