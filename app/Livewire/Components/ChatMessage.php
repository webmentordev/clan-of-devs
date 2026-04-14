<?php

namespace App\Livewire\Components;

use App\Models\Message;
use Livewire\Component;

class ChatMessage extends Component
{
    public Message $message;
    public function render()
    {
        return view('livewire.components.chat-message');
    }
}