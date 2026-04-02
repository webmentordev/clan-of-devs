<?php

namespace App\Livewire\Auth;

use App\Models\Channel;
use App\Models\Workspace;
use Livewire\Component;

class TextChannel extends Component
{
    public $workspace_id, $channel_id;
    
    // public function mount(Workspace $workspace, Channel $channel){
    //     $this->workspace_id = $workspace;
    //     $this->channel_id = $channel;
    // }

    public function render()
    {
        return view('livewire.auth.text-channel');
    }
}