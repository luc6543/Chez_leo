<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;
use App\Models\TableReservation;

class ReservationPage extends Component
{
    public $reservations;
    public $reservationId;
    public $user_id;
    public $table_id;
    public $start_time;
    public $end_time;
    public $active = false;
    public $isModalOpen = false;
    public $users;
    public $tables;

    protected $rules = [
        'user_id' => 'required',
        'table_id' => 'required',
        'start_time' => 'required|date',
        'active' => 'boolean',
    ];

    public function render()
    {
        $this->reservations = Reservation::all();
        $this->users = User::all();
        $this->tables = Table::all();
        return view('livewire.reservation-page');
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
    }

    public function store()
    {
        $this->validate();

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
            ]
        );

        TableReservation::updateOrCreate(
            ['reservation_id' => $reservation->id],
            ['table_id' => $this->table_id]
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