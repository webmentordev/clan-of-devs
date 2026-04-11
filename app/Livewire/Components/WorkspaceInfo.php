<?php

namespace App\Livewire\Components;
use Livewire\Component;

class WorkspaceInfo extends Component
{
    public $data;

    public function mount($data): void
    {
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.components.workspace-info');
    }
}