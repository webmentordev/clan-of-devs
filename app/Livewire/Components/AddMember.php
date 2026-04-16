<?php

namespace App\Livewire\Components;

use App\Models\Member;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddMember extends Component
{
    public $workspace, $users = [], $usersCount = 0;
    public $search = "";

    public function mount($workspace){
        $this->workspace = $workspace;
    }

    public function render()
    {
        return view('livewire.components.add-member');
    }

    public function updatedSearch()
    {
        if ($this->search != "") {
            $query = User::where('id', '!=', Auth::id())
            ->where(function ($q) {
                $q->where('username', 'LIKE', '%' . strtolower($this->search) . '%')
                ->orWhere('email', 'LIKE', '%' . strtolower($this->search) . '%');
            });
            $this->users = (clone $query)->take(2)->get();
            $this->usersCount = $query->count();
        } else {
            $this->users = [];
            $this->usersCount = 0;
        }
    }

    public function add($username){
        $user = User::where('username', $username)->first();
        $workspace = Workspace::where('unique_id', $this->workspace)->first();
        if($workspace){
            if($user){
                $isMember = Member::where('workspace_id', $workspace->id)->where('user_id', $user->id)->first();
                if($isMember){
                    return session()->flash('failed', 'User is already a member!');
                }
                Member::firstOrCreate(
                    ['user_id' => $user->id, 'workspace_id' => $workspace->id],
                    ['role' => 'common']
                );
                return session()->flash('success', 'User been added!');
            }else{
                return session()->flash('failed', 'Can not find the user!');
            }
        }
        return session()->flash('failed', 'Workspace is not found!');
    }
}