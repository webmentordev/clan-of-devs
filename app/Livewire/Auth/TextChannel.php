<?php

namespace App\Livewire\Auth;

use App\Models\Channel;
use App\Models\Workspace;
use Livewire\Component;

class TextChannel extends Component
{
    public $workspace, $channel;
    
    public function mount(Workspace $workspace, Channel $channel){
        $this->workspace = $workspace->load('channels');
        $this->channel = $channel;
    }

    public function render()
    {
        return view('livewire.auth.text-channel');
    }
}