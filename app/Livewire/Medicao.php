<?php

namespace App\Livewire;

use Livewire\Component;

class Medicao extends Component
{
    public $name;

    public function mount()
    {
        $this->name = 'John Doe';
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function render()
    {
        return view('livewire.my-component');
    }
}
