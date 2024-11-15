<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Table;

class TablePage extends Component
{
    public $tables;
    public $tableId;
    public $chairs;
    public $table_number;
    public $isModalOpen = false;

    protected $rules = [
        'chairs' => 'required',
        'table_number' => 'required',
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
        $this->validate();

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

        $table->delete();

        session()->flash('message', 'Table Deleted Successfully.');
    }
}
