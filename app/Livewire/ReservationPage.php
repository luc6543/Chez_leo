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

    protected $rules = [
        'user_id' => 'required',
        'table_id' => 'required',
        'start_time' => 'required|date',
        'active' => 'boolean',
        'people' => 'required',
    ];

    public function render()
    {

        $currentDateTime = Carbon::now();
        $query = Reservation::orderBy('start_time', 'asc');

        if (!$this->showPastReservations) {
            $query->where('end_time', '>=', $currentDateTime);
        }

        if (!$this->showNonActiveReservations) {
            $query->where('active', true);
        }

        $this->reservations = $query->get();
        $this->users = User::all();
        $this->tables = Table::all();
        return view('livewire.reservation-page');
    }

    public function toggleShowPastReservations()
    {
        $this->showPastReservations = !$this->showPastReservations;
    }

    public function toggleShowNonActiveReservations()
    {
        $this->showNonActiveReservations = !$this->showNonActiveReservations;
    }

    public function openModal()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

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

    public function updated($propertyName, $value)
    {
        $this->$propertyName = $value;

        $this->updateTableList();
    }

    public function updateTableList()
    {
        if (!$this->people) {
            $this->tables = Table::all();
            return;
        }

        // Fetch tables with the same or more chairs
        $this->tables = Table::where('chairs', '>=', $this->people)
            ->orderBy('chairs', 'asc')
            ->get();

        // Auto-select the closest matching table if available
        if ($this->tables->count() > 0) {
            $this->table_id = $this->tables->first()->id;
        } else {
            $this->table_id = null;
        }
    }

    public function create() {
        $reservation = new Reservation();
        $reservation->start_time = date('Y-m-d', strtotime(now())) . ' 23:59:00';
        $reservation->end_time = date('Y-m-d', strtotime($this->start_time)) . ' 23:59:00';
        $reservation->user_id = Auth::user()->id;
        $reservation->table_id = 2;
        $reservation->save();
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            session()->flash('error', 'Vul alle velden in.');
            return;
        }

        // Ensure end_time has the same date as start_time but with time set to 23:00
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

        session()->flash('message', $this->reservationId ? 'Reservation Updated Successfully.' : 'Reservation Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

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

        $tableReservation = TableReservation::where('reservation_id', $reservation->id)->first();
        if ($tableReservation) {
            $this->table_id = $tableReservation->table_id;
        }

        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        // Find the reservation
        $reservation = Reservation::findOrFail($id);

        // Delete the related table_reservation entry
        TableReservation::where('reservation_id', $reservation->id)->delete();

        // Delete the reservation
        $reservation->delete();

        // Flash a success message
        session()->flash('message', 'Reservation Deleted Successfully.');
    }
}
