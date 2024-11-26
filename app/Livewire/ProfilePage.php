<?php

namespace App\Livewire;

use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ProfilePage extends Component
{
    const TIME_RANGES = [
        3 => [17, 22], // Wednesday
        4 => [12, 22], // Thursday
        5 => [12, 23], // Friday
        6 => [12, 23], // Saturday
        0 => [12, 23]  // Sunday
    ];
    public $newPass;
    public $newPassConfirm;
    public $reservations;
    public $reservationId;
    public $user_id;
    public $start_time;
    public $end_time;
    public $special_request;
    public $users;

    
    
    // Validatieregels voor invoervelden
    protected $rules = [
        'start_time' => 'required|date|after:today',
    ];

    public function render()
    {
        return view('livewire.profile-page');
    }

    public function mount() {
        $this->reservations = Reservation::all();
        $this->users= User::all();
    }

    // Invoervelden resetten
    public function resetInputFields()
    {
        $this->reservationId = null;
        $this->start_time = '';
        $this->end_time = '';
        $this->special_request = '';
    }

    // Reservering opslaan of bijwerken
    public function store()
    {
        $this->validate();
    
        try {
            // Ensure the date string matches the expected format
            $startTime = Carbon::createFromFormat('d-m-Y H:i', $this->start_time);
        } catch (\Exception $e) {
            // Handle the exception if the date format is invalid
            session()->flash('error', 'Invalid start time format.');
            return;
        }
    
        // Convert start_time and end_time to the proper format
        $dayOfWeek = $startTime->dayOfWeek;
        $hour = $startTime->hour;
    
        // Determine the reservation duration
        if ($hour >= 12 && $hour < 18) {
            // Afternoon: reservation lasts 1.5 hours
            $endTime = $startTime->copy()->addHours(1)->addMinutes(30);
        } else {
            // Evening: reservation lasts 3 hours
            $endTime = $startTime->copy()->addHours(3);
        }
    
        // Check if the end time exceeds the closing time
        if (isset(self::TIME_RANGES[$dayOfWeek])) {
            $closingHour = self::TIME_RANGES[$dayOfWeek][1];
            $closingTime = $startTime->copy()->setTime($closingHour, 0);
    
            if ($endTime->greaterThan($closingTime)) {
                $endTime = $closingTime;
            }
        }
    
        // Set the end_time property
        $this->end_time = $endTime->format('Y-m-d H:i:s');
    
        // Save or update the reservation
        Reservation::updateOrCreate(
            ['id' => $this->reservationId],
            [
                'start_time' => $startTime->format('Y-m-d H:i:s'),
                'end_time' => $this->end_time,
                'special_request' => $this->special_request,
            ]
        );
    
        session()->flash('message', 'Reservation edited successfully.');
        $this->dispatch('close-modal');
        $this->resetInputFields();
    }
    // Reservering bewerken
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);

        $this->reservationId = $reservation->id;
        $this->start_time = date('d-m-Y H:i', strtotime($reservation->start_time));
        $this->end_time = date('Y-m-d', strtotime($reservation->start_time)) . ' 23:59:00';
        $this->special_request = $reservation->special_request;
        $this->dispatch('open-modal');
    }

    //reservering annuleren
    public function annuleerReservering($id){
        $reservation = Reservation::findOrFail($id);

        $reservation->delete();
        session()->flash('message', 'Reservering geannuleerd!');
    }

    // public function passReset() {
    //     $this->validate([
    //         'newPass' => 'required|min:8',
    //         'newPassConfirm' => 'required|same:newPass'
    //     ], [
    //         'newPass.required' => 'Het wachtwoordveld is verplicht.',
    //         'newPass.min' => 'Het wachtwoord moet minimaal 8 tekens lang zijn.',
    //         'newPassConfirm.required' => 'Bevestig het wachtwoord.',
    //         'newPassConfirm.same' => 'De wachtwoorden komen niet overeen.'
    //     ]);

    //     Auth::user()->password = Hash::make($this->newPass);
    //     Auth::user()->save();
    //     $this->dispatch('password-changed');
    //     session()->flash('message', 'wachtwoord sucessvol aangepast!');

    // }
}