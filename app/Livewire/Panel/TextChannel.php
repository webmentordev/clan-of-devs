<?php

namespace App\Livewire\Panel;

use App\Events\MessageCreated;
use App\Models\Channel;
use App\Models\ChannelMember;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class TextChannel extends Component
{
    use WithFileUploads;
    
    public $channel, $message, $files = [];

    public $channel_type = "text", $channel_title = '', $description = "", $is_private = 0;

    public Collection $chat_messages;

    public function mount(Channel $channel){
        $this->channel = $channel->load(['channel_members'])->loadCount('channel_members');
        $this->fill([
            'chat_messages' => Message::where('channel_id', $this->channel->id)->take(20)->get()
        ]);
    }
    
    public function render()
    {
        return view('livewire.panel.text-channel', [
            'channels' => Channel::get(),
            'users' => User::get()
        ]);
    }

    #[On('echo-private:channel.{channel.id},MessageCreated')]
    public function messageCreated($event)
    {
        $message = Message::with('user')->find($event['id']);
        if ($message) {
            $this->chat_messages->push($message);
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
            'channel_id'   => $this->channel->id,
            'message'      => $this->message,
            'files'        => count($this->files) > 0 ? json_encode($files) : null,
        ]);
        $this->chat_messages->push($message);
        broadcast(new MessageCreated($message))->toOthers();
        $this->reset(['message', 'files']);
    }

    public function create_new_channel(){
        $this->validate([
            'channel_type' => ['required', Rule::in(['text', 'voice'])],
            'is_private' => ['required', 'boolean'],
            'description' => ['nullable', 'max:255'],
            'channel_title' => [
                'required', 
                'max:50', 
                Rule::unique('channels', 'title')->where('type', $this->channel_type)
            ]
        ]);
        $channelRecord = Channel::create([
            'title' => Str::slug($this->channel_title),
            'type' => $this->channel_type,
            'description' => $this->channel_type == 'text' ? $this->description: null,
            'is_private' => $this->is_private,
            'unique_id' => strtoupper(uniqid()) . rand(999, 999999)
        ]);
        ChannelMember::create([
            'channel_id' => $channelRecord->id,
            'user_id' => Auth::id()
        ]);
        $this->reset(['channel_title', 'channel_type', 'description', 'is_private']);
        return session()->flash('success', 'Channel created!');
    }
}