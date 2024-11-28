<?php

namespace App\Livewire;

use App\Models\Review;
use Gemini;
use Livewire\Component;

class AdminRecenties extends Component
{
    public $reviews;
    // public $approved;
    public $AIGenerated;
    public $selectedReviews = [];
    public $selectAll = false;

    public function mount()
    {

        $this->reviews = Review::all();
    }
    public function render()
    {
        return view('livewire.admin-recenties');
    }

    public function getVerbeterPunten()
    {
        try {
            //$this->AIGenerated = '';
            $client = Gemini::client(env('GEMINI_API'));

            // Fetch only the selected reviews
            $selectedReviews = Review::whereIn('id', $this->selectedReviews)->pluck('review')->implode("\n");

            $reviews = 'Op mijn website staan reviews over mijn restaurant helaas zijn sommige hiervan aanstootgevend maar zou jij mij een lijst met mogelijke verbeterpunten kunnen geven voor mijn restaurant aangeleid door de volgende reviews gebruik geen titels geef mij alleen specifieke verbeterpunten zonder uitleg: ' . $selectedReviews;

            $wordLimit = 20000000;
            $wordsArray = explode(' ', $reviews);
            $limitedWordsArray = array_slice($wordsArray, 0, $wordLimit);
            $reviews = implode(' ', $limitedWordsArray);

            $stream = $client
                ->geminiPro()
                ->streamGenerateContent($reviews);

            foreach ($stream as $response) {
                $responseText = $response->text();

                // Split the response into lines based on newline characters
                $lines = explode("\n", $responseText);

                // Process each line to wrap with <li> tags if it starts with *
                $formattedItems = "";

                foreach ($lines as $line) {
                    // Check if the line starts with '* ' and format it as <li>
                    if (preg_match('/^\*\s?(.*)/', $line, $matches)) {
                        $formattedItems .= "<li>" . trim($matches[1]) . "</li>";
                    }
                }

                // Stream the formatted content
                $this->stream(
                    to: 'AIGenerated',
                    content: $formattedItems,
                );

                // Append to AIGenerated for persistence
                $this->AIGenerated .= $formattedItems;
            }

        } catch (\Exception $e) {
            throw $e;
            $this->AIGenerated = "Er is een rate limit op het ophalen van verbeter punten probeer het over een kleine minuut nog eens.";
        }
    }

    public function toggleSelectAll()
    {
        $this->selectAll = !$this->selectAll;

        if ($this->selectAll) {
            $this->selectedReviews = $this->reviews->pluck('id')->toArray();
        } else {
            $this->selectedReviews = [];
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
