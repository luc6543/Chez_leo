<?php

namespace App\Livewire;

use Livewire\Component;

class PlattegrondPage extends Component
{
    public $mode = 'figma';
    public function render()
    {
        return view('livewire.plattegrond-page');
    }
    public function changeMode($mode)
    {
        $this->mode = $mode;
    }
}
