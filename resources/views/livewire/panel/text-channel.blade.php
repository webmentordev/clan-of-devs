<section class="flex h-screen">
    <nav class="flex flex-col p-3 h-full border-x border-dark-light-100 w-70 relative">
        <div class="" x-data="{ text_open: true, voice_open: true }">
            <div class="flex items-center justify-between mb-4 text-main" x-data="{ setting: false }">
                <div class="flex items-center">
                    <h2 class="mr-2">{{ Str::limit(config('app.name'), 15, '...')}}</h2>
                </div>
            </div>
            
            {{-- Text Channels --}}
            <button class="w-full flex items-center mb-2" @click="text_open = !text-open">
                <img src="https://api.iconify.design/cuida:caret-down-outline.svg?color=%23888888" width="20px">
                <span class="ml-2 text-white font-semibold text-sm">Text channels</span>
            </button>
            <div class="flex flex-col">
                @foreach ($channels as $txtChannel)
                    @if($txtChannel->type == 'text')
                        @if (!$txtChannel->is_private || $txtChannel->isMember(auth()->id()))
                            <a href="{{ route('channel', $txtChannel->unique_id) }}" wire:navigate class="flex items-center text-sm text-txt-2 font-semibold mb-1 
                            @if ($channel->unique_id == $txtChannel->unique_id)
                                border-main bg-dark border-r-4
                            @endif py-1 px-2 w-full"> 
                            @if (!$txtChannel->is_private)
                                <img src="https://api.iconify.design/clarity:hashtag-solid.svg?color=%23e3e3e3" width="13"><strong class="ml-2">
                            @else
                                <img src="https://api.iconify.design/material-symbols-light:lock.svg?color=%23e3e3e3" width="17"><strong class="ml-2">
                            @endif {{ $txtChannel->title }}</strong></a>
                        @endif
                    @endif
                @endforeach
            </div>

            {{-- Vocie Channels --}}
            <button class="w-full flex items-center mb-2 mt-8" @click="voice_open = !text-open">
                <img src="https://api.iconify.design/cuida:caret-down-outline.svg?color=%23888888" width="20px">
                <span class="ml-2 text-white font-semibold text-sm">Voice channels</span>
            </button>
            <div class="flex flex-col">
                @foreach ($channels as $vChannel)
                    @if($vChannel->type == 'voice')
                        <button class="flex items-center text-sm text-txt-2 font-semibold mb-1 py-1 px-2 w-full"><img src="https://api.iconify.design/mdi:volume-high.svg?color=%23e3e3e3" width="16"> <strong class="ml-2">{{ $vChannel->title }}</strong></button>
                    @endif
                @endforeach
            </div>

            {{-- Members --}}
            <div class="flex items-center justify-between mt-8 mb-2">
                <div class="w-full flex items-center">
                    <img src="https://api.iconify.design/ph:users-three-duotone.svg?color=%23888888" width="20px">
                    <span class="ml-2 text-white font-semibold text-sm">Members</span>
                </div>
            </div>
            <div class="flex flex-col">
                @foreach ($users as $member)
                    <x-cards.mini-profile :name="$member->name" limit="10" :avatar="$member->get_avatar()" :you="$member->user_id == auth()->user()->id" />
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
                        <span class="text-txt-1 text-[10px]">Online</span>
                    </div>
                </div>
                <img src="https://api.iconify.design/material-symbols:settings.svg?color=%23bdbdbd" width="18px">
            </div>
        </div>
    </nav>

    <section class="w-full h-full p-2 flex flex-col justify-between">
        <div class="h-full">
            <div class="w-full border-b border-dark-light-100 pb-3">
                <div class="flex items-center mb-3">
                    <h1 class="text-2xl text-white flex items-center"><img src="https://api.iconify.design/clarity:hashtag-solid.svg?color=%23e3e3e3" width="22px"> general</h1>
                    @if ($channel->is_private)
                        <div class="relative group">
                            <img src="https://api.iconify.design/iconamoon:lock-bold.svg?color=%2315ef57" width="22px" class="ml-2">
                            <span class="hidden group-hover:block transition-all absolute left-8 top-0 bg-black/80 backdrop-blur-lg py-2 px-3 rounded-lg text-white text-sm whitespace-nowrap">Private Channel</span>
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-center w-fit">
                    <img src="https://api.iconify.design/material-symbols:person.svg?color=%23ffffff" width="20px">
                    <p class="text-txt-2 text-sm ml-1">
                        {{ $channel->member_count_label }} - {{ $channel->description }}
                    </p>
                </div>
            </div>
            <div class="mt-4 max-h-178 overflow-y-scroll">
                @forelse ($messages as $single_message)
                    <div class="flex mb-2 p-2 group hover:bg-dark-100 transition-all rounded-md" x-data="{ open: false, shiftHeld: false }"  
                        @keydown.shift.window="shiftHeld = true" 
                        @keyup.shift.window="shiftHeld = false">
                        <img src="{{ $single_message->user->get_avatar() }}" width="40px" height="40px" class="object-fill rounded-full w-10 h-10">
                        <div class="flex flex-col ml-3 w-full">
                            <div class="flex justify-between w-full">
                                <div class="flex items-center">
                                    <h3 class="text-white text-lg">{{ $single_message->user->name }}</h3>
                                    <span class="ml-3 text-txt-1 text-sm">{{ $single_message->created_at->format('d M, y h:i A') }}</span>
                                </div>
                                <div class="relative hidden group-hover:block">
                                    <button class="py-0.5 px-2 rounded-md bg-dark-100 border border-dark-light-100" @click="open = true">
                                        <img src="https://api.iconify.design/mdi:dots-horizontal.svg?color=%23e3e3e3" width="18px">
                                    </button>
                                    <button x-show="shiftHeld" wire:click="delete" title="Delete the message">
                                        <img src="https://api.iconify.design/material-symbols:delete-outline-sharp.svg?color=%23ef1515" width="18px">
                                    </button>
                                    <div class="absolute bg-dark/80 backdrop-blur-sm border border-dark-light-100 rounded-lg p-2 top-8 right-0" style="width: 250px" @click.away="open = false" x-show="open" x-cloak x-transition>
                                        <x-buttons.drop-btn wire:click="delete" :first='true'>Delete</x-buttons.drop-btn>
                                    </div>
                                </div>
                            </div>
                            <p class="text-txt-2 text-sm">{{ $single_message->message }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-txt-2 p-2">Channel is empty</p>
                @endforelse
                <div class="sm:[overflow-anchor:auto] h-px" x-init="$el.scrollIntoView()"></div>
            </div>
        </div>
        <div class="w-full">
            <x-texteditor  placeholder="Message in #{{ $channel->title }}..."
                wire:model="message"
                x-on:keydown.enter="if (!$event.shiftKey) { $event.preventDefault(); $wire.send_message() }">
            </x-texteditor>
        </div>  
    </section>


    <nav class="flex flex-col p-6 h-full border-x border-dark-light-100 bg-dark w-110" x-data="{ add: false }">
        <div class="" x-data="{ open: false }">
            <div class="flex flex-col">
                <h1 class="text-xl text-txt-2 font-semibold mb-3">About the channel</h1>
                <div class="flex items-center border-t border-light">
                    <h2 class="text-2xl text-main font-semibold mb-3 pt-3">#{{ $channel->title }}</h2> 
                    @if ($channel->is_private)
                        <strong class="py-1 px-3 ml-2 rounded-lg border border-green-500 text-green-500 text-[10px]">Private</strong>
                    @endif
                </div>
                <p class="text-txt-2 text-sm mb-3">{{ $channel->description }}</p>
                <h1 class="text-xl text-txt-2 font-semibold my-3">Quick actions</h1>
                <div class="grid grid-cols-4 gap-3">
                    <button @click="add = true" class="flex flex-col justify-center items-center">
                        <div class="bg-dark-100 border border-white/10 rounded-full h-10 w-10 flex items-center justify-center">
                            <img src="https://api.iconify.design/material-symbols:person-add.svg?color=%23bdbdbd" width="18px">
                        </div>
                        <span class="text-white text-[12px] mt-1">Add</span>
                    </button>
                    <button class="flex flex-col justify-center items-center">
                        <div class="bg-dark-100 border border-white/10 rounded-full h-10 w-10 flex items-center justify-center">
                            <img src="https://api.iconify.design/mdi:magnify-expand.svg?color=%23bdbdbd" width="18px">
                        </div>
                        <span class="text-white text-[12px] mt-1">Find</span>
                    </button>
                    <button class="flex flex-col justify-center items-center">
                        <div class="bg-dark-100 border border-white/10 rounded-full h-10 w-10 flex items-center justify-center">
                            <img src="https://api.iconify.design/material-symbols:call.svg?color=%23bdbdbd" width="18px">
                        </div>
                        <span class="text-white text-[12px] mt-1">Call</span>
                    </button>
                    <button class="flex flex-col justify-center items-center">
                        <div class="bg-dark-100 border border-white/10 rounded-full h-10 w-10 flex items-center justify-center">
                            <img src="https://api.iconify.design/solar:menu-dots-line-duotone.svg?color=%23bdbdbd" width="18px">
                        </div>
                        <span class="text-white text-[12px] mt-1">More</span>
                    </button>
                </div>
                
                <div class="w-full mt-6 border-b border-white/10 pb-3" x-show="add" x-cloak x-transition @click.away="add = false">
                    <h3 class="text-white mb-3">Add member in the channel</h3>
                    @session('added')
                        <x-alert-success>{{ $value }}</x-alert-success>
                    @endsession
                    @session('add_failed')
                        <p class="my-3 text-main bg-main/10 p-3 rounded-lg border border-main">{{ $value }}</p>
                    @endsession
                    <x-input class="border-none bg-dark-100 text-white mb-3" wire:model.live.debounce.1000ms="search" placeholder="Search by email or username" />
                    @forelse ($users as $user)
                        <div class="flex items-center justify-between">
                            <x-cards.mini-profile :name="$user->name" :avatar="$user->get_avatar()" />
                            <button  wire:click="add_user('{{ $user->username }}')" class="py-1 px-3 rounded-lg bg-main text-white text-sm">Add</button>
                        </div>
                    @empty
                        <p class="text-gray-400">No users found</p>
                    @endforelse
                </div>

                @if ($channel->is_private && $channel->type == 'text')
                    <div class="flex flex-col my-3 pt-6 border-t border-white/5">
                        <h1 class="text-xl text-txt-2 font-semibold mb-1">Private Members</h1>
                        <div class="flex items-center gap-1.5 py-2.5 border-y border-white/6">
                            <img src="https://api.iconify.design/lucide:users.svg?color=%236b7280" class="w-3.5 h-3.5" alt="">
                            @php $members = $channel->channel_members_count; @endphp
                            <span class="text-txt-2 text-xs">{{ $members }} {{ Str::plural('member', $members) }}</span>
                        </div>
                    </div>
                    @foreach ($channel->channel_members as $member)
                        <x-cards.mini-profile :name="$member->user->name" :avatar="$member->user->get_avatar()" :is_creator="$member->user->id == $channel->user_id" :you="$member->user->id == auth()->user()->id"/>
                    @endforeach
                    @if ($channel->channel_members_count > 10) <p class="text-main text-sm"> and more ...</p> @endif
                @endif
            </div>
            <div wire:loading wire:target="add_user, search">
                <x-alert-processing />
            </div>
        </div>
    </nav>
</section>