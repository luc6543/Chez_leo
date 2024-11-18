<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Table;
use Illuminate\Validation\ValidationException;
use App\Models\TableReservation;

class TablePage extends Component
{
    public $tables;
    public $tableId;
    public $chairs;
    public $table_number;
    public $isModalOpen = false;

    protected $rules = [
        'chairs' => 'required',
        'table_number' => 'required|unique:tables,table_number',
    ];

    public function render()
    {
        $this->tables = Table::all();
        return view('livewire.table-page');
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
        $this->tableId = null;
        $this->chairs = '';
        $this->table_number = '';
    }

    public function store()
    {
        try {
            $this->validate([
                'chairs' => 'required',
                'table_number' => 'required|unique:tables,table_number,' . $this->tableId,
            ]);
        } catch (ValidationException $e) {
            session()->flash('error', 'Vul alle velden in en zorg ervoor dat het tafelnummer uniek is.');
            return;
        }

        $table = Table::updateOrCreate(
            ['id' => $this->tableId],
            [
                'chairs' => $this->chairs,
                'table_number' => $this->table_number,
            ]
        );

        session()->flash('message', $this->tableId ? 'Table Updated Successfully.' : 'Table Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $table = Table::findOrFail($id);

        $this->tableId = $table->id;
        $this->chairs = $table->chairs;
        $this->table_number = $table->table_number;

        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        $table = Table::findOrFail($id);

        TableReservation::where('table_id', $table->id)->delete();

        $table->delete();

        session()->flash('message', 'Table Deleted Successfully.');
    }
}
