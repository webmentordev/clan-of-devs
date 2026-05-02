<?php

namespace App\Policies;

use App\Models\ChannelMember;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChannelMemberPolicy
{

    public function remove_from_channel(User $user, ChannelMember $channelMember): bool
    {
        return false;
    }
}