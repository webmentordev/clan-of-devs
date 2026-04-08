<?php

namespace App\Livewire\Auth;

use App\Models\Member;
use App\Models\Workspace;
use App\Models\WorkspaceCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Workspaces extends Component
{
    public $workspaces = [], $workspace_data = null;

    public function mount(?WorkspaceCategory $workspace_category = null)
    {
        $this->workspaces = $workspace_category ? $workspace_category->workspaces->loadCount(['members']) : Workspace::latest()->withCount(['members'])->take(30)->get();
        $this->assign_data("69D2456B71B26432300");
    }

    public function render()
    {
        return view('livewire.auth.workspaces', [
            'workspaces' => $this->workspaces,
        ]);
    }

    public function assign_data($unique_id)
    {
        $record = Workspace::where('unique_id', $unique_id)->with(['category', 'first_members'])->withCount(['members', 'channels', 'public_channels'])->first();
        if($record){
            $this->workspace_data = $record;
            return;
        }
        abort(404);
    }

    public function join_workspace($unique_id){
        $record = Workspace::where('unique_id', $unique_id)->first();
        if($record){
            $member = Member::where('user_id', Auth::user()->id)->where("workspace_id", $record->id)->first();
            if(!$member){
                Member::create([
                    'user_id' => Auth::user()->id,
                    'workspace_id' => $record->id,
                    'role' => 'common'
                ]);
            }
        }
    }
}