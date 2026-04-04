<?php

namespace App\Livewire\Components;

use App\Models\Workspace;
use Livewire\Component;

class WorkspaceNav extends Component
{
    public function render()
    {
        return view('livewire.components.workspace-nav', [
            'workspaces' => Workspace::orderBy('title')->get()
        ]);
    }

    public function redirectToRoute(){
        $this->redirectRoute('create.workspace');
    }
}