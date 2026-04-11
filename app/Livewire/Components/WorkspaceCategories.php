<?php

namespace App\Livewire\Components;

use App\Models\WorkspaceCategory;
use Livewire\Component;

class WorkspaceCategories extends Component
{
    public function render()
    {
        return view('livewire.components.workspace-categories', [
            'categories' => WorkspaceCategory::orderBy('title')->withCount(['workspaces'])->get()
        ]);
    }
}