<?php

namespace App\Livewire;

use App\Models\Channel;
use Livewire\Component;

class Home extends Component
{
    public function mount(){
        $general_chat = Channel::where('title', 'general-chat')->first();
        $this->redirectRoute('channel', ['channel' => $general_chat->unique_id]);
    }
    
    public function render()
    {
        return view('livewire.home');
    }
}