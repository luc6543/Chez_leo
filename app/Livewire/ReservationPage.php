<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;
use App\Models\ReservationTable;
use Carbon\Carbon;

class ReservationPage extends Component
{
    // Declareren van publieke eigenschappen
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
        'table_ids' => 'required|array|min:1',
    ];

    public function validateFields()
    {
        $errorMessage = '';
        // if (empty(trim($this->user_id)) && empty(trim($this->guest_name))) {
        //     $errorMessage .= 'Er moet een gebruiker of gastnaam worden geselecteerd.<br>';
        // }
        // if (empty($this->start_time) || $this->start_time == null) {
        //     $errorMessage .= 'Er moet een starttijd worden geselecteerd.<br>';
        // }
        // if (empty($this->people) || $this->people == null) {
        //     $errorMessage .= 'Er moet een aantal personen worden ingevuld.<br>';
        // }
        // if (empty($this->table_ids) || $this->table_ids == null) {
        //     $errorMessage .= 'Er moet minimaal één tafel worden geselecteerd.<br>';
        // }

        // if ($errorMessage) {
        //     session()->flash('error', $errorMessage);
        //     return;
        // }
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
            $endTime = Reservation::calculateEndTime($startTime);

            $usedTableIds = ReservationTable::getUsedTableIds($this->reservationId, $startTime, $endTime);

            // Fetch tables that are available
            $this->tables = Table::whereNotIn('id', $usedTableIds)
                ->orderBy('chairs', 'asc')
                ->get();
        } else {
            // Fetch all tables when no specific time is selected
            $this->tables = Table::orderBy('chairs', 'asc')->get();
        }
    }

    public function calculateMaxChairs()
    {
        $tempMaxChairs = 0;
        foreach ($this->tables as $table) {
            $tempMaxChairs += $table->chairs;
        }
        $this->maxChairs = $tempMaxChairs;
    }

    public function toggleTable($id)
    {
        if (($key = array_search($id, $this->table_ids)) !== false) {
            unset($this->table_ids[$key]);
        } else {
            $this->table_ids[] = $id;
        }
    }

    public function autoSelectTables()
{
    // Clear existing selections
    $this->table_ids = [];
    
    // Handle edge cases where there are no people or tables.
    if (!$this->people || empty($this->tables)) {
        return;
    }

    // Sort tables by the number of chairs in ascending order to prioritize minimal use.
    $sortedTables = $this->tables->sortBy('chairs');

    $remainingPeople = $this->people;

    // Check for an exact match or the smallest sufficient table.
    foreach ($sortedTables as $table) {
        if ($table->chairs >= $remainingPeople) {
            $this->table_ids[] = $table->id;
            return;
        }
    }

    // Fall back to combining tables if no single table fits.
    foreach ($sortedTables as $table) {
        if ($remainingPeople <= 0) break;

        $this->table_ids[] = $table->id;
        $remainingPeople -= $table->chairs;
    }
}



    // Reservering opslaan of bijwerken
    public function store()
    {
        $this->validateFields();
        $this->validate([
            'user_id' => 'required_if:guest_name,null',
            'guest_name' => 'required_if:user_id,null',
            'start_time' => 'required|date_format:d-m-Y H:i',
            'people' => 'required|integer|min:1',
            'table_ids' => 'required|array|min:1',
        ], [
            'required_if' => 'Het veld klant is verplicht.',
            'required' => 'Het veld :attribute is verplicht.',
            'string' => 'Het veld :attribute moet een tekst zijn.',
            'max' => 'Het veld :attribute mag niet meer dan :max tekens bevatten.',
            'min' => 'Het veld :attribute moet minimaal :min tekens bevatten.',
            'email' => 'Het veld :attribute moet een geldig e-mailadres zijn.',
            'same' => 'Het veld :attribute en :other moeten overeenkomen.',
            'integer' => 'Het veld :attribute moet een getal zijn.',
            'date_format' => 'Het veld :attribute moet een geldige datum en tijd zijn.',
            'array' => 'Het veld :attribute moet een array zijn.',
            'table_ids.required' => 'Het veld tafels is verplicht.',
            'table_ids.array' => 'Het veld tafels moet een array zijn.',
            'table_ids.min' => 'Selecteer minimaal één tafel.',
        ]);
        
        
        $startTime = Carbon::createFromFormat('d-m-Y H:i', $this->start_time);

        $endTime = Reservation::calculateEndTime($startTime);

        // Set the end_time property
        $this->end_time = $endTime->format('Y-m-d H:i:s');

        // Format the start_time property
        $format_start_time = Carbon::parse($this->start_time)->format('Y-m-d H:i:s');

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
        $this->table_ids = $reservation->tables->pluck('id')->toArray();
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