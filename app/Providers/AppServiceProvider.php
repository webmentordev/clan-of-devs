<?php

namespace App\Providers;

use App\Models\Channel;
use App\Models\Workspace;
use App\Policies\ChannelPolicy;
use App\Policies\WorkspacePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Gate::policy(Channel::class, ChannelPolicy::class);
        Gate::policy(Workspace::class, WorkspacePolicy::class);
    }

    public function boot(): void
    {
        //
    }
}