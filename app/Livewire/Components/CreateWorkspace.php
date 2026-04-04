<?php

namespace App\Livewire\Components;

use App\Models\Channel;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateWorkspace extends Component
{
    use WithFileUploads;

    public $title, $logo, $description;
    
    public $default_channels = [
        "text" => [
            [
                "name" => "general",
                "deletable" => false,
                'description' => 'General chat channel for all workspace members.'
            ],
            [
                "name" => "meetings",
                "deletable" => false,
                'description' => 'Meeting chat channel for all workspace members for work related announcements.'
            ]
        ],
        "voice" => [
            [
                "name" => "general-chat",
                "deletable" => false,
                'description' => null
            ],
            [
                "name" => "crew-meeting",
                "deletable" => false,
                'description' => null
            ]
        ],
    ];
    
    #[On('workspace-created')]
    public function render()
    {
        return view('livewire.components.create-workspace');
    }

    public function create(){
        $this->validate([
            'title' => ['required', 'max:255'],
            'logo' => ['required', 'image', 'max:2024'],
            'description' => ['required']
        ]);
        $workspace = Workspace::create([
            'title' => $this->title,
            'logo' => $this->logo->store('logos', 'public'),
            'description' => $this->description,
            'unique_id' => strtoupper(uniqid()).rand(999,999999),
            'user_id' => Auth::user()->id
        ]);
        foreach ($this->default_channels as $type => $channels) {
            foreach ($channels as $channel) {
                Channel::create([
                    'title'        => $channel['name'],
                    'type'         => $type,
                    'slug'         => Str::slug($channel['name']),
                    'unique_id'    => strtoupper(uniqid()) . rand(999, 999999),
                    'workspace_id' => $workspace->id,
                    'is_deletable' => $channel['deletable'],
                    'user_id'      => Auth::user()->id,
                    'description'  => $channel['description'],
                ]);
            }
        }
        $this->reset(['title', 'description']);
        $this->dispatch('workspace-created'); 
        session()->flash('success', 'Workspace has been created!');
    }
}