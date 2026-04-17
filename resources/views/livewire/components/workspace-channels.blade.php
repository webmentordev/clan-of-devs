<nav class="flex flex-col p-3 h-full border-x border-dark-light-100 w-80 relative">
    <div class="" x-data="{ text_open: true, voice_open: true }">
        <div class="flex items-center justify-between mb-4 text-main" x-data="{ setting: false }">
            <div class="flex items-center">
                <h2 class="mr-2">{{ Str::limit($workspace->title, 15, '...')}}</h2>
                @if (!$workspace->is_public)
                    <img src="https://api.iconify.design/iconamoon:lock-bold.svg?color=%2315ef57" width="20px">
                @endif
            </div>
            <button @click="setting = true" class><img src="https://api.iconify.design/material-symbols:settings.svg?color=%23bdbdbd" width="20px"></button>
            <div class="z-50 top-0 left-0 bg-dark/10 backdrop-blur-lg w-full h-full fixed" x-show="setting" x-cloak x-transition>
                <div class="w-full h-full flex items-center justify-center" @click.self="setting = false">
                    <div class="max-w-2xl w-full p-6 bg-dark border border-white/10 rounded-lg">
                        <h3 class="text-white mb-3">Update worspace settings</h3>
                        @session('success_setting')
                            <x-alert-success>{{ $value }}</x-alert-success>
                        @endsession
                        @session('failed_setting')
                            <x-alert-failed>{{ $value }}</x-alert-failed>
                        @endsession
                        <div class="flex items-center justify-between">
                            <h3 class="text-main">Workspace visibility</h3>
                            <button wire:click="toggle_visibility" class="py-1 px-4 bg-main text-white rounded-lg">
                                @if ($workspace->is_public)
                                    Public
                                @else
                                    Private
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
                <div wire:loading wire:target="add">
                    <x-alert-processing />
                </div>
            </div>
        </div>
        
        {{-- Text channels --}}
        <button class="w-full flex items-center mb-2" @click="text_open = !text-open">
            <img src="https://api.iconify.design/cuida:caret-down-outline.svg?color=%23888888" width="20px">
            <span class="ml-2 text-white font-semibold text-sm">Text channels</span>
        </button>
        <div class="flex flex-col">
            @foreach ($channels as $channel)
                @if($channel->type == 'text')
                    @if (!$channel->is_private || $channel->isMember(auth()->id()))
                        <a href="{{ route('text.channel', [$workspace_uid, $channel->unique_id]) }}" wire:navigate class="flex items-center text-sm text-txt-2 font-semibold mb-1 
                        @if ($channel_uid == $channel->unique_id)
                            border-main bg-dark border-r-4
                        @endif py-1 px-2 w-full"> 
                        @if (!$channel->is_private)
                            <img src="https://api.iconify.design/clarity:hashtag-solid.svg?color=%23e3e3e3" width="13"><strong class="ml-2">
                        @else
                            <img src="https://api.iconify.design/material-symbols-light:lock.svg?color=%23e3e3e3" width="17"><strong class="ml-2">
                        @endif {{ $channel->title }}</strong></a>
                    @endif
                @endif
            @endforeach
        </div>

        {{-- Voice channels --}}
        <button class="w-full flex items-center mb-2 mt-8" @click="voice_open = !text-open">
            <img src="https://api.iconify.design/cuida:caret-down-outline.svg?color=%23888888" width="20px">
            <span class="ml-2 text-white font-semibold text-sm">Voice channels</span>
        </button>
        <div class="flex flex-col">
            @foreach ($channels as $channel)
                @if($channel->type == 'voice')
                    <button class="flex items-center text-sm text-txt-2 font-semibold mb-1 py-1 px-2 w-full"><img src="https://api.iconify.design/mdi:volume-high.svg?color=%23e3e3e3" width="16"> <strong class="ml-2">{{ $channel->title }}</strong></button>
                @endif
            @endforeach
        </div>

        {{-- Members --}}
        <div class="flex items-center justify-between mt-8 mb-2">
            <div class="w-full flex items-center">
                <img src="https://api.iconify.design/ph:users-three-duotone.svg?color=%23888888" width="20px">
                <span class="ml-2 text-white font-semibold text-sm">Members</span>
            </div>
            @livewire('components.add-member', ['workspace' => $workspace_uid])
        </div>
        <div class="flex flex-col">
            @foreach ($members as $member)
                <x-cards.mini-profile :name="$member->user->name" limit="10" :avatar="$member->user->get_avatar()" :you="$member->user_id == auth()->user()->id" />
            @endforeach
        </div>
    </div>
    <div class="absolute bottom-0 p-2 left-0 w-full">
        <div class="bg-dark-100/90 backdrop-blur-md border border-white/10 rounded-lg p-2 flex justify-between items-center">
            <div class="w-fit flex items-center">
                <div class="relative w-fit">
                    <div class="w-8 h-8 bg-cover bg-center rounded-full" style="background-image: url('{{ auth()->user()->get_avatar() }}')"></div>
                    <div class="absolute w-2.5 h-2.5 bg-green-500 rounded-full bottom-0 right-0 border border-black"></div>
                </div>
                <div class="ml-2 flex flex-col">
                    <h2 class="text-txt-2 text-[12px]">{{ Str::limit(auth()->user()->name, 12, '...') }}</h2>
                    <span class="text-txt-1 text-[10px]" title="{{ auth()->user()->username }}">{{ '@'.Str::limit(auth()->user()->username, 12, '...') }}</span>
                </div>
            </div>
            <a href="{{ route('profile') }}">
                <img src="https://api.iconify.design/material-symbols:settings.svg?color=%23bdbdbd" width="18px">
            </a>
        </div>
    </div>
</nav>