<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;

class ReservationPage extends Component
{
    public $reservations;
    public $reservationId;
    public $user_id;
    public $table_id;
    public $start_time;
    public $end_time;
    public $isModalOpen = false;
    public $users;
    public $tables;

    protected $rules = [
        'user_id' => 'required',
        'table_id' => 'required',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
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
    }

    public function store()
    {
        $this->validate();

        Reservation::updateOrCreate(
            ['id' => $this->reservationId],
            [
                'user_id' => $this->user_id,
                'table_id' => $this->table_id,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
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
        $this->end_time = $reservation->end_time;

        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        Reservation::find($id)->delete();
        session()->flash('message', 'Reservation Deleted Successfully.');
    }
}