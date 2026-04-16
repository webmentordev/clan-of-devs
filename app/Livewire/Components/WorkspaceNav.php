<?php

namespace App\Livewire\Components;

use App\Models\Member;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class WorkspaceNav extends Component
{

    #[On("workspace-created")]
    public function render()
    {
        return view('livewire.components.workspace-nav', [
            'members' => Member::where('user_id', Auth::user()->id)->get()
        ]);
    }

    public function redirectToRoute(){
        $this->redirectRoute('create.workspace');
    }
}