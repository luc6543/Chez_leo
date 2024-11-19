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

        $this->users = User::all();
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
        $reservation = Reservation::findOrFail($id);

        TableReservation::where('reservation_id', $reservation->id)->delete();

        $reservation->delete();

        session()->flash('message', 'Reservation Deleted Successfully.');
    }
}
