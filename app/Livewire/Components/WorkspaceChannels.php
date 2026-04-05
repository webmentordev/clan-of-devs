<?php

namespace App\Livewire\Components;

use Livewire\Component;

class WorkspaceChannels extends Component
{
    public $channels, $workspace_uid, $channel_uid;
    
    public function render()
    {
        return view('livewire.components.workspace-channels');
    }
}