<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Auth\Access\Response;

class WorkspacePolicy
{
    public function view_workspace(User $user, Workspace $workspace): bool
    {
        return $workspace->user_id === $user->id ||
           $workspace->members()
               ->where('user_id', $user->id)
               ->exists();
    }
}