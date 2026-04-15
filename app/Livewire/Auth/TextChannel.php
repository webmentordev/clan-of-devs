<?php

namespace App\Livewire\Auth;

use App\Events\MessageCreated;
use App\Models\Channel;
use App\Models\Message;
use App\Models\Workspace;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class TextChannel extends Component
{
    use WithFileUploads;
    
    public $workspace, $channel, $message, $files = [];
    public Collection $messages;
    
    public function mount(Workspace $workspace, Channel $channel)
    {
        $this->authorize('view', [$channel, $workspace]);
        
        $this->workspace = $workspace->load(['channels',])->loadCount('members');
        $this->channel = $channel->load(['channel_members'])->loadCount('channel_members');
        $this->fill([
            'messages' => Message::where('channel_id', $this->channel->id)->take(20)->get()
        ]);
    }

    public function render()
    {
        return view('livewire.auth.text-channel');
    }

    #[On('echo-private:channel.{channel.id},MessageCreated')]
    public function messageCreated($event)
    {
        $message = Message::with('user')->find($event['id']);
        if ($message) {
            $this->messages->push($message);
        }
    }

    public function send_message(){
        if(trim($this->message) == ""){
            return;
        }
        $files = [];
        if(count($this->files)){
            foreach($this->files as $file){
                $files[] = $file->store('uploads', 'public');
            }
        }
        $message = Message::create([
            'user_id'      => Auth::id(),
            'workspace_id' => $this->workspace->id,
            'channel_id'   => $this->channel->id,
            'message'      => $this->message,
            'files'        => count($this->files) > 0 ? json_encode($files) : null,
        ]);
        $this->messages->push($message);
        broadcast(new MessageCreated($message))->toOthers();
        $this->reset(['message', 'files']);
    }
}