<?php

namespace App\Livewire\Components;

use App\Models\ChannelMember;
use App\Models\Member;
use App\Models\User;
use Livewire\Component;

class WorkspaceChannelInfo extends Component
{
    public $channel = null;
    public $search = '';
    public $users = [];

    public function render()
    {
        return view('livewire.components.workspace-channel-info');
    }

    public function updatedSearch()
    {
        if($this->search != ""){
            $workspaceMembers = Member::where('workspace_id', $this->channel->workspace_id)
            ->with('user')
            ->get()
            ->pluck('user_id')
            ->toArray();
        $channelMembers = ChannelMember::where('channel_id', $this->channel->id)
            ->pluck('user_id')
            ->toArray();
        $this->users = User::whereIn('id', $workspaceMembers)
            ->whereNotIn('id', $channelMembers)
            ->where(function($query) {
                $query->where('email', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%');
            })
            ->get();
        }else{
            $this->users = [];
        }
    }

    public function add_user($username)
    {
        try {
            $user = User::where('username', $username)->firstOrFail();
            ChannelMember::create([
                'workspace_id' => $this->channel->workspace_id,
                'channel_id' => $this->channel->id,
                'user_id' => $user->id,
            ]);
            session()->flash('added', "{$user->name} has been added to the channel");
            $this->updatedSearch();
        } catch (\Exception $e) {
            session()->flash('add_failed', 'Failed to add member');
        }
    }
}