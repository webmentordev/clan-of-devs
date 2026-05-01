<?php

namespace App\Livewire\Panel;

use App\Events\MessageCreated;
use App\Mail\AddMember;
use App\Models\Channel;
use App\Models\ChannelMember;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class TextChannel extends Component
{
    use WithFileUploads;
    
    public $channel, $message, $files = [], $search = '';

    public $channel_type = "text", $channel_title = '', $description = "", $is_private = 0;

    public $email, $name, $role = 'common';

    public $user_name, $avatar = null, $profile_avatar = null;

    public Collection $chat_messages;

    public function mount(Channel $channel){
        $this->channel = $channel->load(['channel_members'])->loadCount('channel_members');
        $this->fill([
            'chat_messages' => Message::where('channel_id', $this->channel->id)->latest()->take(20)->get()->reverse()
        ]);
        $user = Auth::user();
        $this->user_name = $user->name;
        $this->profile_avatar = $user->get_avatar();
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
        $this->authorize('is_admin');
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


    public function add_new_member(){
        $this->authorize('is_owner');
        
        $this->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'common'])]
        ]);
        $domain = config('app.email_domain');
        if(Str::afterLast($this->email, '@') == $domain || $domain == ''){
            $password = $this->randomPassword(12);
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
                'password' => $password
            ]);
            $resetToken = Password::createToken($user);
            Mail::to($this->email)->send(new AddMember(
                $user,
                $password,
                $resetToken
            ));
            $this->reset(['name', 'email', 'role']);
            return session()->flash('add_success', 'User has been added.');
        }else{
            return session()->flash('add_failed', 'Add user with professional email @'. $domain);
        }
    }

    private function randomPassword($length = 8) {
        $alphabet = 'abcdefghijklmnopqrs!@#$%^&*()_+tuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function delete(Message $message){
        $this->authorize('delete_message', $message);
        $message->delete();
        $this->chat_messages = $this->chat_messages->filter(fn($msg) => $msg->id !== $message->id);
    }

    public function update_profile(){
        $this->validate([
            'user_name' => ['required', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2024'],
        ]);

        $user = Auth::user();
        $avatar = null;
        if($this->avatar){
            $avatar = $this->avatar->store('avatars');
            if (!str_contains($this->profile_avatar, 'avatar.png')) {
                $oldPath = str_replace(config('app.url') . '/storage/', '', $this->profile_avatar);
                if (Storage::disk('public_disk')->exists($oldPath)) {
                    Storage::disk('public_disk')->delete($oldPath);
                }
            }
        }
        $user->update(array_filter([
            'name' => $this->user_name,
            'avatar' => $avatar
        ]));
        $this->reset(['avatar']);
        $this->profile_avatar = Auth::user()->get_avatar();
        return session()->flash('profile_success', 'Profile updated!');
    }
}