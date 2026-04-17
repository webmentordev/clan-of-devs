<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Home extends Component
{
    public function mount(){
        $this->redirectRoute('workspaces');
    }
    public function render()
    {
        return view('livewire.home');
    }
}