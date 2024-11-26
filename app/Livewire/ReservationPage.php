<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ReservationPage extends Component
{
    // Declareren van publieke eigenschappen
    const TIME_RANGES = [
        3 => [17, 22], // Wednesday
        4 => [12, 22], // Thursday
        5 => [12, 23], // Friday
        6 => [12, 23], // Saturday
        0 => [12, 23]  // Sunday
    ];
    public $reservations;
    public $reservationId;
    public $user_id;
    public $guest_name;
    public $table_id;
    public $start_time;
    public $end_time;
    public $active = false;
    public $people;
    public $isModalOpen = false;
    public $users;
    public $tables;
    public $showPastReservations = false;
    public $showNonActiveReservations = false;
    public $originalTableId;
    public $special_request;
    public $maxChairs;
    public $showGuestNameInput = false;

    // Validatieregels voor invoervelden
    protected $rules = [
        'user_id' => 'nullable',
        'guest_name' => 'nullable',
        'table_id' => 'required',
        'start_time' => 'required|date|after:today',
        'active' => 'boolean',
        'people' => 'required',
    ];
    public function messages()
    {
        return [
            'table_id.required' => 'De tafel is verplicht.',
            'start_time.required' => 'De starttijd is verplicht.',
            'start_time.date' => 'De starttijd moet een geldige datum zijn.',
            'start_time.after' => 'De starttijd moet na vandaag zijn.',
            'active.boolean' => 'De status moet een waar of onwaar waarde zijn.',
            'people.required' => 'Het aantal personen is verplicht.',
        ];
    }

    // Renderen van de component
    public function render()
    {
        // Huidige datum en tijd ophalen
        $currentDateTime = Carbon::now();
        $query = Reservation::orderBy('start_time', 'asc');

        // Filteren op toekomstige reserveringen
        if (!$this->showPastReservations) {
            $query->where('end_time', '>=', $currentDateTime);
        }

        // Filteren op actieve reserveringen
        if (!$this->showNonActiveReservations) {
            $query->where('active', true);
        }

        // Ophalen van reserveringen
        $this->reservations = $query->get();

        // Beschikbare tafels ophalen
        if ($this->start_time) {
            $date = Carbon::parse($this->start_time)->format('Y-m-d');
            $usedTableIds = Reservation::whereDate('start_time', '<=', $date)
                ->whereDate('end_time', '>=', $date)
                ->pluck('table_id')
                ->toArray();

            // Include the original table attached to the reservation being edited
            if ($this->originalTableId) {
                $usedTableIds = array_diff($usedTableIds, [$this->originalTableId]);
            }

            $this->tables = Table::whereNotIn('id', $usedTableIds)->get();
        } else {
            $this->tables = Table::all();
        }

        // Berekenen van het maximale aantal stoelen
        $this->calculateMaxChairs();

        // Alle gebruikers ophalen
        $this->users = User::all();
        return view('livewire.reservation-page');
    }

    // Toggle knop voor tonen van oude reserveringen
    public function toggleShowPastReservations()
    {
        $this->showPastReservations = !$this->showPastReservations;
    }

    // Toggle knop voor tonen van niet-actieve reserveringen
    public function toggleShowNonActiveReservations()
    {
        $this->showNonActiveReservations = !$this->showNonActiveReservations;
    }

    public function toggleGuestInput()
    {
        $this->showGuestNameInput = !$this->showGuestNameInput;
    }

    // Invoervelden resetten
    public function resetInputFields()
    {
        $this->reservationId = null;
        $this->user_id = null;
        $this->guest_name = '';
        $this->table_id = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->active = false;
        $this->people = '';
        $this->originalTableId = null;
        $this->special_request = '';
    }

    // Bijwerken van specifieke eigenschappen
    public function updated($propertyName, $value)
    {
        $this->$propertyName = $value;

        $this->updateTableList();
    }

    // Bijwerken van de lijst met beschikbare tafels
    public function updateTableList()
    {
        if (!$this->people || $this->people > Table::max('chairs')) {
            $this->tables = Table::all();
            return;
        }

        if ($this->start_time) {
            $date = Carbon::parse($this->start_time)->format('Y-m-d');

            $usedTableIds = Reservation::whereDate('start_time', '<=', $date)
                ->whereDate('end_time', '>=', $date)
                ->pluck('table_id')
                ->toArray();

            // Include the original table attached to the reservation being edited
            if ($this->originalTableId) {
                $usedTableIds = array_diff($usedTableIds, [$this->originalTableId]);
            }

            $this->tables = Table::where('chairs', '>=', $this->people)
                ->whereNotIn('id', $usedTableIds)
                ->orderBy('chairs', 'asc')
                ->get();
        } else {
            $this->tables = Table::where('chairs', '>=', $this->people)
                ->orderBy('chairs', 'asc')
                ->get();
        }

        $this->table_id = $this->tables->count() > 0 ? $this->tables->first()->id : null;
    }

    public function calculateMaxChairs()
    {
        $tempMaxChairs = 0;
        foreach ($this->tables as $table) {
            $tempMaxChairs += $table->chairs;
        }
        $this->maxChairs = $tempMaxChairs;
    }

    // Nieuwe reservering aanmaken
    public function create()
    {
        $reservation = new Reservation();
        $reservation->start_time = date('Y-m-d', strtotime(now())) . ' 23:59:00';
        $reservation->end_time = date('Y-m-d', strtotime($this->start_time)) . ' 23:59:00';
        $reservation->user_id = Auth::user()->id;
        $reservation->table_id = 2;
        $reservation->save();
    }

    // Reservering opslaan of bijwerken
    public function store()
    {
        $this->validate();

        $startTime = Carbon::createFromFormat('d-m-Y H:i', $this->start_time);
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
        $format_start_time = Carbon::parse($this->start_time)->format('Y-m-d H:i:s');

        $reservation = Reservation::updateOrCreate(
            ['id' => $this->reservationId],
            [
                'user_id' => $this->user_id,
                'guest_name' => $this->guest_name,
                'table_id' => $this->table_id,
                'start_time' => $format_start_time,
                'end_time' => $this->end_time,
                'active' => $this->active,
                'people' => $this->people,
                'special_request' => $this->special_request,
            ]
        );

        session()->flash('message', $this->reservationId ? 'Reservering bijgewerkt.' : 'Reservering aangemaakt.');

        $this->dispatch('close-modal');
        $this->resetInputFields();
    }

    // Reservering bewerken
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);

        $this->reservationId = $reservation->id;
        $this->user_id = $reservation->user_id;
        $this->guest_name = $reservation->guest_name;
        $this->table_id = $reservation->table_id;
        $this->start_time = date('d-m-Y H:i', strtotime($reservation->start_time));
        $this->end_time = date('Y-m-d', strtotime($reservation->start_time));
        $this->active = $reservation->active;
        $this->people = $reservation->people;
        $this->special_request = $reservation->special_request;
        $this->originalTableId = $reservation->table_id;

        $this->dispatch('open-modal');
    }

    // Reservering verwijderen
    public function delete($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->delete();

        session()->flash('message', 'Reservering succesvol verwijderd.');
    }
}
