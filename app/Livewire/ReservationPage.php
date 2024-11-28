<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;
use App\Models\ReservationTable;
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
    public $table_ids = [];
    public $start_time;
    public $end_time;
    public $active = false;
    public $people;
    public $isModalOpen = false;
    public $users;
    public $tables;
    public $showPastReservations = false;
    public $showNonActiveReservations = false;
    public $originalTableIds = [];
    public $special_request;
    public $maxChairs;
    public $showGuestNameInput = false;

    // Validatieregels voor invoervelden
    protected $rules = [
        'user_id' => 'nullable',
        'guest_name' => 'nullable',
        'start_time' => 'required|date|after:today',
        'active' => 'boolean',
        'people' => 'required',
    ];
    public function messages()
    {
        return [
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

        // Ophalen van beschikbare tafels
        $this->updateTableList();

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
        $this->start_time = '';
        $this->end_time = '';
        $this->active = false;
        $this->people = '';
        $this->originalTableIds = [];
        $this->special_request = '';
    }

    // Bijwerken van specifieke eigenschappen
    public function updated($propertyName, $value)
    {
        $this->calculateMaxChairs();
    }

    // Bijwerken van de lijst met beschikbare tafels
    public function updateTableList()
    {
        if ($this->start_time) {
            $startTime = Carbon::parse($this->start_time);
            $endTime = $this->calculateEndTime($startTime);

            $usedTableIds = ReservationTable::join('reservations', 'reservation_tables.reservation_id', '=', 'reservations.id')
                ->where('reservations.id', '!=', $this->reservationId) // Exclude the current reservation being edited
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where(function ($query) use ($startTime) {
                        $query->where('reservations.start_time', '<', $startTime)
                            ->where('reservations.end_time', '>', $startTime);
                    })->orWhere(function ($query) use ($endTime) {
                        $query->where('reservations.start_time', '<', $endTime)
                            ->where('reservations.end_time', '>', $endTime);
                    })->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('reservations.start_time', '>=', $startTime)
                            ->where('reservations.end_time', '<=', $endTime);
                    });
                })
                ->pluck('reservation_tables.table_id')
                ->toArray();

            // Fetch tables that are available
            $this->tables = Table::whereNotIn('id', $usedTableIds)
                ->orderBy('chairs', 'asc')
                ->get();
        } else {
            // Fetch all tables when no specific time is selected
            $this->tables = Table::orderBy('chairs', 'asc')->get();
        }
    }

    private function calculateEndTime($startTime)
    {
        $dayOfWeek = $startTime->dayOfWeek;
        $hour = $startTime->hour;

        if ($hour >= 12 && $hour < 18) {
            // Afternoon: reservation lasts 1.5 hours
            $endTime = $startTime->copy()->addHours(1)->addMinutes(30);
        } else {
            // Evening: reservation lasts 3 hours
            $endTime = $startTime->copy()->addHours(3);
        }

        if (isset(self::TIME_RANGES[$dayOfWeek])) {
            $closingHour = self::TIME_RANGES[$dayOfWeek][1];
            $closingTime = $startTime->copy()->setTime($closingHour, 0);

            if ($endTime->greaterThan($closingTime)) {
                $endTime = $closingTime;
            }
        }
        return $endTime;
    }



    public function calculateMaxChairs()
    {
        $tempMaxChairs = 0;
        foreach ($this->tables as $table) {
            $tempMaxChairs += $table->chairs;
        }
        $this->maxChairs = $tempMaxChairs;
    }

    // Reservering opslaan of bijwerken
    public function store()
    {
        $this->validate();

        $startTime = Carbon::createFromFormat('d-m-Y H:i', $this->start_time);

        $endTime = $this->calculateEndTime($startTime);

        // Set the end_time property
        $this->end_time = $endTime->format('Y-m-d H:i:s');

        // Format the start_time property
        $format_start_time = Carbon::parse($this->start_time)->format('Y-m-d H:i:s');

        // Check if the guest_name is empty or contains only spaces
        if (empty(trim($this->guest_name))) {
            $this->guest_name = null;
        }

        $reservation = Reservation::updateOrCreate(
            ['id' => $this->reservationId],
            [
                'user_id' => $this->user_id,
                'guest_name' => $this->guest_name,
                'start_time' => $format_start_time,
                'end_time' => $this->end_time,
                'active' => $this->active,
                'people' => $this->people,
                'special_request' => $this->special_request,
            ]
        );

        if ($this->table_ids) {
            $reservation->tables()->sync($this->table_ids);
        }

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
        $this->start_time = date('d-m-Y H:i', strtotime($reservation->start_time));
        $this->end_time = date('Y-m-d', strtotime($reservation->start_time));
        $this->active = $reservation->active;
        $this->people = $reservation->people;
        $this->special_request = $reservation->special_request;
        $this->originalTableIds = $reservation->tables->pluck('id')->toArray();

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
