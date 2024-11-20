<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ProfilePage extends Component
{
    public $newPass;
    public $newPassConfirm;
    public function render()
    {
        return view('livewire.profile-page');
    }

    public function mount() {

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
        session()->flash('message', 'Password Changed Successfully');

    }
}
