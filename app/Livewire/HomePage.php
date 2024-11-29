<?php

namespace App\Livewire;

use App\Mail\NewTemporaryPasswordMail;
use App\Models\Product;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Table;
use App\Models\User;
use App\Models\ReservationTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Exception;
use Carbon\Carbon;

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
    public $people = 1;
    public $special_request;
    public $reviews;

    public function mount()
    {
        $this->products = Product::Where("category", "Lunch")->get();
        $this->reviews = Review::all();
    }
    public function render()
    {
        return view('livewire.home-page');
    }
    public function filter($category)
    {
        $this->category = $category;
        $this->products = Product::Where("category", $category)->get();
        // dd($category);
        sleep(0.5);
    }

    public function createReservation()
    {
        $this->start_time = Carbon::createFromFormat('d-m-Y H:i', $this->start_time);
        try {
            $errorMessage = '';

            if (!Auth::check()) {
                if ($this->name == null) {
                    $errorMessage .= 'Vul uw naam in.<br>';
                }
                if ($this->email == null) {
                    $errorMessage .= 'Vul uw e-mailadres in.<br>';
                } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                    $errorMessage .= 'Vul een correct e-mailadres in.<br>';
                } elseif (User::where('email', $this->email)->exists()) {
                    $errorMessage .= 'Dit e-mailadres is al in gebruik.<br>';
                }
            }
            if ($this->start_time == null) {
                $errorMessage .= 'Vul een datum in.<br>';
            } else {
                $startTime = Carbon::parse($this->start_time);
                if ($startTime->lt(Carbon::now()->addHour())) {
                    $errorMessage .= 'De datum mag niet in het verleden liggen.<br>';
                } elseif ($startTime->lt(Carbon::now()->addHour()->addMinutes(29))) {
                    $errorMessage .= 'Reserveringen moeten minstens 30 minuten van tevoren worden gemaakt.<br>Als u eerder een tafel nodig heeft, neem dan telefonisch contact met ons op.<br>';
                }
            }
            if ($this->people == null) {
                $errorMessage .= 'Vul het aantal personen in.<br>';
            }

            if ($errorMessage) {
                session()->flash('error', $errorMessage);
                return;
            }

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
                    Password::sendResetLink(['email' => $this->email]);
                    //            Mail::to($this->email)->send(new NewTemporaryPasswordMail($user, $temporaryPassword));
                }
            }

            // Convert start_time and end_time to the proper format
            $startTime = Carbon::parse($this->start_time);
            $endTime = Reservation::calculateEndTime($startTime);

            // Set the end_time property
            $this->end_time = $endTime->format('Y-m-d H:i:s');

            // Find an available table with the required number of chairs
            $startTime = Carbon::parse($this->start_time);

            $usedTableIds = ReservationTable::getUsedTableIds($this->reservationId, $startTime, $endTime);

            $availableTables = Table::where('chairs', '>=', $this->people)
                ->whereNotIn('id', $usedTableIds)
                ->orderBy('chairs', 'asc')
                ->get();

            $this->table_id = $availableTables->count() > 0 ? $availableTables->first()->id : null;

            if ($this->table_id) {
                // Create the reservation
                $reservation = Reservation::create([
                    'id' => $this->reservationId,
                    'user_id' => $user->id,
                    'table_id' => 1,
                    'people' => (int) $this->people,
                    'special_request' => $this->special_request,
                    'paid' => false,
                    'present' => false,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                ]);

                $reservation->tables()->sync([$this->table_id]);

                // Show a success message
                $successMessage = 'Uw reservering is succesvol aangemaakt.';
                if (!Auth::check()) {
                    $successMessage .= "<br>Er is een account voor u aangemaakt met uw gegevens.<br>U ontvangt een e-mail waar u uw wachtwoord kan instellen.";
                }
                $successMessage .= "<br>Op uw profiel pagina kunt u uw reservering activeren.";
                session()->flash('success', $successMessage);

            } else {
                // Handle the case where no table is available
                session()->flash('error', 'Er is geen tafel beschikbaar voor de geselecteerde datum en het aantal personen.');
            }

            // Reset the form fields
            $this->reset(['name', 'email', 'start_time', 'people', 'special_request']);

        } catch (Exception $e) {
            session()->flash('error', 'Er is een fout opgetreden bij het maken van de reservering.');
        }
    }
}
