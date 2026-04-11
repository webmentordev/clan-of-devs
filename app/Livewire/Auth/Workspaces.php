<?php

namespace App\Livewire\Auth;

use App\Models\Member;
use App\Models\Workspace;
use App\Models\WorkspaceCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Workspaces extends Component
{
    public $workspace_data = null;
    public $workspace_category_id = null;

    public function mount(?WorkspaceCategory $workspace_category = null)
    {
        $this->workspace_category_id = $workspace_category?->id;
        // $this->assign_data("69D2456B71B26432300");
    }

    public function render()
    {
        $workspaces = $this->workspace_category_id
            ? WorkspaceCategory::find($this->workspace_category_id)
                ->workspaces()
                ->withCount('members')
                ->get()
            : Workspace::latest()->withCount('members')->take(30)->get();
        return view('livewire.auth.workspaces', [
            'workspaces' => $workspaces,
        ]);
    }

    public function assign_data($unique_id)
    {
        $record = Workspace::where('unique_id', $unique_id)
            ->with(['category', 'first_members'])
            ->withCount(['members', 'channels', 'public_channels'])
            ->first();

        if ($record) {
            $this->workspace_data = $record;
            return;
        }

        abort(404);
    }

    public function join_workspace($unique_id)
    {
        $record = Workspace::where('unique_id', $unique_id)->first();
        if ($record) {
            $member = Member::where('user_id', Auth::id())
                ->where('workspace_id', $record->id)
                ->first();

            if (!$member) {
                Member::create([
                    'user_id'      => Auth::id(),
                    'workspace_id' => $record->id,
                    'role'         => 'common',
                ]);
            }
        }
    }
}