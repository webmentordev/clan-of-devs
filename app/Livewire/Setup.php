<?php

namespace App\Livewire;

use App\Models\Channel;
use App\Models\ChannelMember;
use App\Models\User;
use Livewire\Component;

class Setup extends Component
{
    public $name = '', $email = '', $password = '', $password_confirmation = '';
    
    public $default_channels = [
        "text" => [
            [
                "title" => "general",
                'description' => 'General chat channel for all workspace members.',
            ],
            [
                "title" => "meetings",
                'description' => 'Meeting chat channel for all workspace members for work related announcements.'
            ]
        ],
        "voice" => [
            [
                "title" => "general-chat",
                'description' => null,
            ],
            [
                "title" => "crew-meeting",
                'description' => null
            ]
        ],
    ];
    
    public function mount(){
        if(User::first()){
            abort(403);
        }
    }
    
    public function render()
    {
        return view('livewire.setup');
    }

    public function create_user(){
        $this->validate([
            'name'     => ['required', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:255', 'confirmed'],
        ]);
        $user = User::first();
        $newUser = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
            'role' => !$user ? 'owner' : 'common',
        ]);
        foreach ($this->default_channels as $type => $channels) {
            foreach ($channels as $channel) {
                $channel = Channel::create([
                    'title'        => $channel['title'],
                    'type'         => $type,
                    'unique_id'    => strtoupper(uniqid()) . rand(999, 999999),
                    'is_deletable' => false,
                    'is_default'   => true,
                    'description'  => $channel['description'],
                ]);
                ChannelMember::create([
                    'user_id' => $newUser->id,
                    'channel_id' => $channel->id,
                ]);
            }
        }
        session()->flash('success', 'Setup has been completed!');
        $this->redirectRoute('login');
    }
}