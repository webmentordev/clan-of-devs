<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MessagePolicy
{
    public function delete_message(User $user, Message $message): bool
    {
        return $message->user_id == $user->id || in_array($user->role, ['owner', 'admin']);
    }
}