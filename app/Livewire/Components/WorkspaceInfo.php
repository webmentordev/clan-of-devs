<?php

namespace App\Livewire\Components;

use App\Models\Workspace;
use Livewire\Component;

class WorkspaceInfo extends Component
{
    public $data = null;

    public function render()
    {
        return view('livewire.components.workspace-info');
    }
}