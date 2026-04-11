<?php

namespace App\Livewire\Auth;

use App\Models\Member;
use App\Models\Workspace;
use App\Models\WorkspaceCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Workspaces extends Component
{
    public $workspace_category_id = null;
    public ?string $selected_workspace_id = null;

    public function mount(?WorkspaceCategory $workspace_category = null)
    {
        $this->workspace_category_id = $workspace_category?->id;
    }

    public function render()
    {
        $workspaces = $this->workspace_category_id
            ? WorkspaceCategory::find($this->workspace_category_id)
                ->workspaces()
                ->withCount('members')
                ->get()
            : Workspace::latest()->withCount('members')->take(30)->get();

        $workspace_data = $this->selected_workspace_id
            ? Workspace::where('unique_id', $this->selected_workspace_id)
                ->with(['category', 'first_members'])
                ->withCount(['members', 'channels', 'public_channels'])
                ->first()
            : null;

        return view('livewire.auth.workspaces', [
            'workspaces'     => $workspaces,
            'workspace_data' => $workspace_data,
        ]);
    }

    public function assign_data(string $unique_id)
    {
        $this->selected_workspace_id = $unique_id;
    }

    public function join_workspace(string $unique_id)
    {
        $record = Workspace::where('unique_id', $unique_id)->first();
        if ($record) {
            Member::firstOrCreate(
                ['user_id' => Auth::id(), 'workspace_id' => $record->id,],
                ['role' => 'common']
            );
        }
    }
}