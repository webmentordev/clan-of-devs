<?php

namespace App\Providers;

use App\Models\Channel;
use App\Models\Message;
use App\Models\User;
use App\Policies\ChannelPolicy;
use App\Policies\MessagePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Gate::policy(Channel::class, ChannelPolicy::class);
        Gate::policy(Message::class, MessagePolicy::class);
    }

    public function boot(): void
    {
        Gate::define('is_owner', fn(User $user) => $user->role === 'owner');
        Gate::define('is_admin', fn(User $user) => $user->role === 'admin' || $user->role === 'owner');
    }
}