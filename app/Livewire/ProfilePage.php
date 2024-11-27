<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\Review;

class ProfilePage extends Component
{
    public $newPass;
    public $newPassConfirm;
    public $reviews;
    public function render()
    {
        return view('livewire.profile-page');
    }

    public function mount() {
        $this->reviews = Review::where('user_id', Auth::id())->get();
    }

    public function passReset() {
        $this->validate([
            'newPass' => 'required|min:8',
            'newPassConfirm' => 'required|same:newPass'
        ], [
            'newPass.required' => 'Het wachtwoordveld is verplicht.',
            'newPass.min' => 'Het wachtwoord moet minimaal 8 tekens lang zijn.',
            'newPassConfirm.required' => 'Bevestig het wachtwoord.',
            'newPassConfirm.same' => 'De wachtwoorden komen niet overeen.'
        ]);

        Auth::user()->password = Hash::make($this->newPass);
        Auth::user()->save();
        $this->dispatch('password-changed');
        session()->flash('message', 'wachtwoord sucessvol aangepast!');

    }

    public function deleteReview($reviewId)
    {
        $review = Review::where('id', $reviewId)
                        ->where('user_id', Auth::id()) // Alleen recensies van de gebruiker
                        ->first();

        if ($review) {
            $review->delete();
            session()->flash('message', 'Recensie succesvol verwijderd!');
        } else {
            session()->flash('error', 'Geen toegang om deze recensie te verwijderen.');
        }
    }

}
