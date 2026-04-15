<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Auth\Access\Response;

class ChannelPolicy
{
    public function view(User $user, Channel $channel, Workspace $workspace): bool
    {
        if (!$channel->is_private) {
            return true;
        }
        return  $user->id === $channel->user_id || $user->id === $workspace->user_id || $channel->isMember($user->id);
    }

    public function update(User $user, Channel $channel, Workspace $workspace): bool
    {
        return $user->id === $channel->user_id || $user->id === $workspace->user_id;
    }

    public function delete(User $user, Channel $channel, Workspace $workspace): bool
    {
        return $user->id === $channel->user_id || $user->id === $workspace->user_id;
    }
}