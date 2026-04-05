<?php

namespace App\Livewire\Auth;

use App\Models\Channel;
use App\Models\Workspace;
use Livewire\Component;

class TextChannel extends Component
{
    public $workspace, $channel;
    
    public function mount(Workspace $workspace, Channel $channel)
    {
        $this->workspace = $workspace->load('channels')->loadCount('members');
        $this->channel = $channel->load(['workspace' => fn($query) => $query->withCount('members')])->loadCount('channel_members');
    }

    public function render()
    {
        return view('livewire.auth.text-channel');
    }
}