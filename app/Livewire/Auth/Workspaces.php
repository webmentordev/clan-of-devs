<?php

namespace App\Livewire\Auth;

use App\Models\Workspace;
use App\Models\WorkspaceCategory;
use Livewire\Component;

class Workspaces extends Component
{
    public $workspaces = [];

    public function mount(?WorkspaceCategory $workspace_category = null)
    {
        $this->workspaces = $workspace_category ? $workspace_category->workspaces->loadCount(['members']) : Workspace::latest()->withCount(['members'])->take(30)->get();
    }

    public function render()
    {
        return view('livewire.auth.workspaces', [
            'workspaces' => $this->workspaces,
        ]);
    }
}