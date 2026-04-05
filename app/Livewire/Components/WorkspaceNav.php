<?php

namespace App\Livewire\Components;

use App\Models\Workspace;
use Livewire\Attributes\On;
use Livewire\Component;

class WorkspaceNav extends Component
{

    #[On("workspace-created")]
    public function render()
    {
        return view('livewire.components.workspace-nav', [
            'workspaces' => Workspace::orderBy('title')->with(['channels', 'general_chat'])->get()
        ]);
    }

    public function redirectToRoute(){
        $this->redirectRoute('create.workspace');
    }
}