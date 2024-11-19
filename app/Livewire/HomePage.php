<?php

namespace App\Livewire;

use App\Mail\NewTemporaryPasswordMail;
use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class HomePage extends Component
{
    public $products;
    public $category = "Lunch";
    public $name;
    public $email;
    public $end_time;
    public $user_id;
    public $table_id;
    public $start_time;
    public $users;
    public $tables;
    public $reservationId;
    public $people;
    public $special_request;

    public function mount()
    {
        $this->products = Product::Where("category", "Lunch")->get();
    }
    public function render()
    {
        $this->users = User::all();

        return view('livewire.home-page');
    }
    public function filter($category)
    {
        $this->category = $category;
        $this->products = Product::Where("category", $category)->get();
        sleep(0.5);
    }

    public function createReservation()
    {
        // Check if the user is logged in
        if (Auth::check()) {
            // Use the authenticated user's information
            $user = Auth::user();

        } else {
            // Search for a user by email or create a new one
            $user = User::where('email', $this->email)->first();

            if (!$user) {
                // Create a new user with a temporary password
                $temporaryPassword = Str::random(8);
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($temporaryPassword),
                ]);

                // Send an email with the temporary password
                Mail::to($this->email)->send(new NewTemporaryPasswordMail($user, $temporaryPassword));
            }
        }


        // Convert start_time and end_time to the proper format
        $this->start_time = date('Y-m-d', strtotime($this->start_time));
        $this->end_time = date('Y-m-d', strtotime($this->start_time)) . ' 23:59:00';

        // Create the reservation
        Reservation::create([
            'id' => $this->reservationId,
            'user_id' => $user->id,
            'table_id' => $this->table_id = 1,
            'people' => (int) $this->people,
            'special_request' => $this->special_request,
            'paid' => false,
            'present' => false,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);
        // if(Auth::check() ){
        //     Mail::to($user->email)->send(new NewTemporaryPasswordMail($user, $this->start_time, $this->end_time));
        // }
    }

}
