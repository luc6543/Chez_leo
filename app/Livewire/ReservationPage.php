<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;
use App\Models\TableReservation;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ReservationPage extends Component
{
    // Declareren van publieke eigenschappen
    public $reservations;
    public $reservationId;
    public $user_id;
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

    // Validatieregels voor invoervelden
    protected $rules = [
        'user_id' => 'required',
        'table_id' => 'required',
        'start_time' => 'required|date',
        'active' => 'boolean',
        'people' => 'required',
    ];

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

            $this->tables = Table::whereNotIn('id', $usedTableIds)->get();
        } else {
            $this->tables = Table::all();
        }

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

    // Modal venster openen
    public function openModal()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    // Modal venster sluiten
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    // Invoervelden resetten
    public function resetInputFields()
    {
        $this->reservationId = null;
        $this->user_id = '';
        $this->table_id = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->active = false;
        $this->people = '';
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
        if (!$this->people) {
            $this->tables = Table::all();
            return;
        }

        if ($this->start_time) {
            $date = Carbon::parse($this->start_time)->format('Y-m-d');

            $usedTableIds = Reservation::whereDate('start_time', '<=', $date)
                ->whereDate('end_time', '>=', $date)
                ->pluck('table_id')
                ->toArray();

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
        try {
            $this->validate();
        } catch (ValidationException $e) {
            session()->flash('error', 'Vul alle velden in.');
            return;
        }

        $this->end_time = date('Y-m-d', strtotime($this->start_time)) . ' 23:59:00';

        $reservation = Reservation::updateOrCreate(
            ['id' => $this->reservationId],
            [
                'user_id' => $this->user_id,
                'table_id' => $this->table_id,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'active' => $this->active,
                'people' => $this->people,
            ]
        );

        session()->flash('message', $this->reservationId ? 'Reservering bijgewerkt.' : 'Reservering aangemaakt.');

        $this->closeModal();
        $this->resetInputFields();
    }

    // Reservering bewerken
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);

        $this->reservationId = $reservation->id;
        $this->user_id = $reservation->user_id;
        $this->table_id = $reservation->table_id;
        $this->start_time = $reservation->start_time;
        $this->end_time = date('Y-m-d', strtotime($reservation->start_time)) . ' 23:59:00';
        $this->active = $reservation->active;
        $this->people = $reservation->people;

        $tableReservation = TableReservation::where('reservation_id', $reservation->id)->first();
        if ($tableReservation) {
            $this->table_id = $tableReservation->table_id;
        }

        $this->isModalOpen = true;
    }

    // Reservering verwijderen
    public function delete($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->delete();

        session()->flash('message', 'Reservering succesvol verwijderd.');
    }
}
