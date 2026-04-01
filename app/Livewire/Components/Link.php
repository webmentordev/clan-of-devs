<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Link extends Component
{
    public $id, $name, $route;
    
    public function render()
    {
        return view('livewire.components.link');
    }
}