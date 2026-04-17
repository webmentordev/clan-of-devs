<?php

namespace App\Livewire\Components;

use App\Models\Member;
use App\Models\Workspace;
use Illuminate\Support\Collection;
use Livewire\Component;

class WorkspaceChannels extends Component
{
    public $channels, $workspace_uid, $channel_uid;
    public $workspace;

    public Collection $members;

    public function mount(){
        $this->workspace = Workspace::where('unique_id', $this->workspace_uid)->first();
        $this->fill([
            'members' => Member::where('workspace_id', $this->workspace->id)->take(20)->get()
        ]);
    }
    
    public function render()
    {
        return view('livewire.components.workspace-channels');
    }

    public function toggle_visibility(){
        $this->workspace->is_public = !$this->workspace->is_public;
        $this->workspace->save();
        session()->flash('success_setting', 'Workspace visibility has been changed!');
    }
}