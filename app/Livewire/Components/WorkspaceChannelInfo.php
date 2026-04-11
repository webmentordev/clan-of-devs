<?php

namespace App\Livewire\Components;

use Livewire\Component;

class WorkspaceChannelInfo extends Component
{
    public $channel = null;

    public function render()
    {
        return view('livewire.components.workspace-channel-info');
    }
}