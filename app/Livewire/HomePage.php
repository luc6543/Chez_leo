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
use Exception;
use Carbon\Carbon;

class HomePage extends Component
{
    const TIME_RANGES = [
        3 => [17, 22], // Wednesday
        4 => [12, 22], // Thursday
        5 => [12, 23], // Friday
        6 => [12, 23], // Saturday
        0 => [12, 23]  // Sunday
    ];
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
    public $people = 1;
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
        try {
            if (!Auth::check() && $this->name == null) {
                session()->flash('error', 'Vul je naam in.');
            } elseif (!Auth::check() && $this->email == null) {
                session()->flash('error', 'Vul je e-mailadres in.');
            } elseif (!Auth::check() && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                session()->flash('error', 'Vul een correct e-mailadres in.');
            } elseif (!Auth::check() && User::where('email', $this->email)->exists()) {
                session()->flash('error', 'Dit e-mailadres is al in gebruik.');
            } elseif ($this->start_time == null) {
                session()->flash('error', 'Vul een datum in.');
            } elseif (Carbon::parse($this->start_time)->isPast()) {
                session()->flash('error', 'De datum mag niet in het verleden liggen.');
            } elseif (Carbon::parse($this->start_time)->lt(Carbon::now()->addHours(2))) {
                session()->flash('error', 'Reserveringen moeten minstens 2 uur van tevoren worden gemaakt.');
            } elseif ($this->people == null) {
                session()->flash('error', 'Vul het aantal personen in.');
            } else {

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
                $startTime = Carbon::parse($this->start_time);
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

                // Find an available table with the required number of chairs
                $date = Carbon::parse($this->start_time)->format('Y-m-d');

                $usedTableIds = Reservation::whereDate('start_time', '<=', $date)
                    ->whereDate('end_time', '>=', $date)
                    ->pluck('table_id')
                    ->toArray();

                $availableTables = Table::where('chairs', '>=', $this->people)
                    ->whereNotIn('id', $usedTableIds)
                    ->orderBy('chairs', 'asc')
                    ->get();

                $this->table_id = $availableTables->count() > 0 ? $availableTables->first()->id : null;

                if ($this->table_id) {
                    // Create the reservation
                    Reservation::create([
                        'id' => $this->reservationId,
                        'user_id' => $user->id,
                        'table_id' => $this->table_id,
                        'people' => (int) $this->people,
                        'special_request' => $this->special_request,
                        'paid' => false,
                        'present' => false,
                        'start_time' => $this->start_time,
                        'end_time' => $this->end_time,
                    ]);
                    // Show a success message
                    session()->flash('success', 'Je reservering is succesvol aangemaakt.');
                } else {
                    // Handle the case where no table is available
                    session()->flash('error', 'Er is geen tafel beschikbaar voor de geselecteerde datum en het aantal personen.');
                }

                // Reset the form fields
                $this->reset(['name', 'email', 'start_time', 'people', 'special_request']);
            }
        } catch (Exception $e) {
            session()->flash('error', 'Er is een fout opgetreden bij het maken van de reservering.');
        }

    }
}
