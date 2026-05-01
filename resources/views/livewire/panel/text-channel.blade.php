<section class="flex h-screen" x-data="{ update_profile_modal: false }">
    <nav class="flex flex-col p-3 h-full border-x border-dark-light-100 w-70 relative">
        <div class="" x-data="{ text_open: $persist(false).as('text-open'), voice_open: $persist(false).as('voice-open'), create_channel: false, add_member: false, config: false }">
            <div class="flex items-center justify-between mb-4 text-main" x-data="{ setting: false }">
                <div class="flex items-center">
                    <h2 class="mr-2">{{ Str::limit(config('app.name'), 15, '...')}}</h2>
                </div>
                <button @click="config = true">
                    <img src="https://api.iconify.design/material-symbols:settings.svg?color=%23bdbdbd" width="18px">
                </button>
                <div class="bg-dark-100 p-4 absolute top-12 left-1 z-10 border border-white/10 rounded-lg" style="width: 200px" @click.away="config = false" x-show="config" x-cloak x-transition>
                    <button class="text-txt-2 mb-2">Settings</button>
                    <form action="{{ route('logout') }}" method="post" class="pt-3 border-t border-white/10">
                        @csrf
                        <button class="py-2 rounded-lg w-full bg-main text-white text-sm">Logout</button>
                    </form>
                </div>
            </div>
            
            {{-- Text Channels --}}
            <div class="flex items-center justify-between mb-2">
                <button class="w-full flex items-center" @click="text_open = !text_open">
                    <img src="https://api.iconify.design/cuida:caret-down-outline.svg?color=%23888888" width="20px" :class="{ '-rotate-90': !text_open }">
                    <span class="ml-2 text-white font-semibold text-sm">Text channels</span>
                </button>
                @can('is_admin')
                    <button @click="create_channel = true" wire:click="$set('channel_type', 'text')">
                        <img src="https://api.iconify.design/material-symbols:add-2-rounded.svg?color=%23ffa0a1" width="20px">
                    </button>
                @endcan
            </div>
            <div class="flex flex-col" x-show="text_open" x-cloak x-transition>
                @foreach ($channels as $txtChannel)
                    @if($txtChannel->type == 'text' )
                        @if (!$txtChannel->is_private || $txtChannel->isMember(auth()->id()))
                            <a href="{{ route('channel', $txtChannel->unique_id) }}" wire:navigate class="flex items-center text-sm text-txt-2 font-semibold mb-1 
                                @if ($channel->unique_id == $txtChannel->unique_id)
                                    border-main bg-dark border-r-4
                                @endif py-1 px-2 w-full"> 
                                @if (!$txtChannel->is_private)
                                    <img src="https://api.iconify.design/clarity:hashtag-solid.svg?color=%23e3e3e3" width="13"><strong class="ml-2" title="{{ $txtChannel->title }}">
                                @else
                                    <img src="https://api.iconify.design/material-symbols-light:lock.svg?color=%23e3e3e3" width="17"><strong class="ml-2" title="{{ $txtChannel->title }}">
                                @endif {{ Str::limit($txtChannel->title, 18, '...') }}</strong></a>
                        @endif
                    @endif
                @endforeach
            </div>

            {{-- Vocie Channels --}}
            <div class="flex items-center justify-between mt-8 mb-2">
                <button class="w-full flex items-center" @click="voice_open = !voice_open">
                    <img src="https://api.iconify.design/cuida:caret-down-outline.svg?color=%23888888" width="20px" :class="{ '-rotate-90': !voice_open }">
                    <span class="ml-2 text-white font-semibold text-sm">Voice channels</span>
                </button>
                @can('is_admin')
                    <button @click="create_channel = true" wire:click="$set('channel_type', 'voice')">
                        <img src="https://api.iconify.design/material-symbols:add-2-rounded.svg?color=%23ffa0a1" width="20px">
                    </button>
                    <div class="z-50 top-0 left-0 bg-dark/10 backdrop-blur-lg w-full h-full fixed" x-show="create_channel" x-cloak x-transition>
                        <div class="w-full h-full flex items-center justify-center" @click.self="create_channel = false">
                            <div class="max-w-2xl w-full p-6 bg-dark border border-white/10 rounded-lg">
                                <h3 class="text-white mb-3 text-lg">Create new channel</h3>
                                @session('success')
                                    <x-alert-success>{{ $value }}</x-alert-success>
                                @endsession
                                @session('failed')
                                    <x-alert-failed>{{ $value }}</x-alert-failed>
                                @endsession
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="w-full mb-3">
                                        <x-dark.label for="channel_type">Channel type</x-dark.label>
                                        <x-dark.select id="channel_type" wire:model="channel_type" required>
                                            <option value="text">Text channel</option>
                                            <option value="voice">Voice channel</option>
                                        </x-dark.select>
                                        @error('channel_type')
                                            <x-error>{{ $message }}</x-error>
                                        @enderror
                                    </div>
                                    <div class="w-full mb-3">
                                        <x-dark.label for="is_private">Channel visiblity</x-dark.label>
                                        <x-dark.select wire:model="is_private" required>
                                            <option value="0">Public</option>
                                            <option value="1">Private</option>
                                        </x-dark.select>
                                        @error('is_private')
                                            <x-error>{{ $message }}</x-error>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full mb-3">
                                    <x-dark.label for="channel_title">Channel title <span class="text-main">(unique)</span></x-dark.label>
                                    <x-dark.input id="channel_title" wire:model="channel_title" required />
                                    @error('channel_title')
                                        <x-error>{{ $message }}</x-error>
                                    @enderror
                                </div>
                                @if ($channel_type == 'text')
                                    <div class="w-full mb-3">
                                        <x-dark.label for="description">Channel description</x-dark.label>
                                        <x-dark.textarea id="description" rows="6" wire:model="description" required></x-dark.textarea>
                                        @error('description')
                                            <x-error>{{ $message }}</x-error>
                                        @enderror
                                    </div>
                                @endif
                                <button wire:click="create_new_channel" class="py-1 px-4 bg-main text-white rounded-lg">
                                    Create
                                </button>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
            <div class="flex flex-col" x-show="voice_open" x-cloak x-transition>
                @foreach ($channels as $vChannel)
                    @if($vChannel->type == 'voice')
                        <button class="flex items-center text-sm text-txt-2 font-semibold mb-1 py-1 px-2 w-full"><img src="https://api.iconify.design/mdi:volume-high.svg?color=%23e3e3e3" width="16"> <strong title="{{ $vChannel->title }}" class="ml-2">{{ Str::limit($vChannel->title, 18, '...') }}</strong></button>
                    @endif
                @endforeach
            </div>

            {{-- Members --}}
            <div class="flex items-center justify-between mt-8 mb-2">
                <div class="w-full flex items-center">
                    <img src="https://api.iconify.design/ph:users-three-duotone.svg?color=%23888888" width="20px">
                    <span class="ml-2 text-white font-semibold text-sm">Members</span>
                </div>
                @can('is_owner')
                    <button @click="add_member = true">
                        <img src="https://api.iconify.design/material-symbols:add-2-rounded.svg?color=%23ffa0a1" width="20px">
                    </button>
                    <div class="z-50 top-0 left-0 bg-dark/10 backdrop-blur-lg w-full h-full fixed" x-show="add_member" x-cloak x-transition>
                        <div class="w-full h-full flex items-center justify-center" @click.self="add_member = false">
                            <div class="max-w-2xl w-full p-6 bg-dark border border-white/10 rounded-lg">
                                <h3 class="text-white mb-3 text-lg">Add new member</h3>
                                @session('add_success')
                                    <x-alert-success>{{ $value }}</x-alert-success>
                                @endsession
                                @session('add_failed')
                                    <x-alert-failed>{{ $value }}</x-alert-failed>
                                @endsession
                                <div class="w-full mb-3">
                                    <x-dark.label for="name">Member name</x-dark.label>
                                    <x-dark.input id="name" wire:model="name" required />
                                    @error('name')
                                        <x-error>{{ $message }}</x-error>
                                    @enderror
                                </div>
                                <div class="w-full mb-3">
                                    <x-dark.label for="email">Email address</x-dark.label>
                                    <x-dark.input id="email" type="email" wire:model="email" required />
                                    @error('email')
                                        <x-error>{{ $message }}</x-error>
                                    @enderror
                                </div>
                                <div class="w-full mb-3">
                                        <x-dark.label for="role">Member role</x-dark.label>
                                        <x-dark.select wire:model="role" required>
                                            <option value="admin">Admin</option>
                                            <option value="common">Common</option>
                                        </x-dark.select>
                                        @error('role')
                                            <x-error>{{ $message }}</x-error>
                                        @enderror
                                    </div>
                                <p class="text-txt-1">* Password will be auto generated & sent in the email.</p>
                                <p class="text-txt-1">* User will be able to update the password & name.</p>
                                <button wire:click="add_new_member" class="py-1 mt-3 px-4 bg-main text-white rounded-lg">
                                    Add & send email
                                </button>
                            </div>
                        </div>
                    </div>
                @endcan
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
                <button @click="update_profile_modal = true">
                    <img src="https://api.iconify.design/material-symbols:settings.svg?color=%23bdbdbd" width="18px">
                </button>
            </div>
        </div>
        <div class="z-50 top-0 left-0 bg-dark/10 backdrop-blur-lg w-full h-full fixed" x-show="update_profile_modal" x-cloak x-transition>
            <div class="w-full h-full flex items-center justify-center" @click.self="update_profile_modal = false">
                <div class="max-w-2xl w-full p-6 bg-dark border border-white/10 rounded-lg">
                    <h3 class="text-white mb-3 text-lg">Update profile</h3>
                    @session('profile_success')
                        <x-alert-success>{{ $value }}</x-alert-success>
                    @endsession
                    <div class="m-auto w-50 h-50 bg-center bg-cover rounded-full"
                        style="background-image: url('{{ $avatar ? $avatar?->temporaryUrl() : $profile_avatar }}')">
                    </div>
                    <div class="w-full mb-3">
                        <x-dark.label for="user_name">Name</x-dark.label>
                        <x-dark.input id="user_name" wire:model="user_name" required />
                        @error('user_name')
                            <x-error>{{ $message }}</x-error>
                        @enderror
                    </div>
                    <div class="w-full mb-3">
                        <x-dark.label for="avatar">Avatar</x-dark.label>
                        <x-dark.input type="file" id="avatar" wire:model="avatar" accept="image/*" />
                        @error('avatar')
                            <x-error>{{ $message }}</x-error>
                        @enderror
                    </div>
                    <button wire:click="update_profile" class="py-1 px-4 bg-main text-white rounded-lg">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <section class="w-full h-full p-2 flex flex-col justify-between">
        <div class="h-full">
            <div class="w-full border-b border-dark-light-100 pb-3">
                <div class="flex items-center mb-3">
                    <h1 class="text-2xl text-white flex items-center"><img src="https://api.iconify.design/clarity:hashtag-solid.svg?color=%23e3e3e3" width="22px"> {{ $channel->title }}</h1>
                    @if ($channel->is_private)
                        <div class="relative group">
                            <img src="https://api.iconify.design/iconamoon:lock-bold.svg?color=%2315ef57" width="22px" class="ml-2">
                            <span class="hidden group-hover:block transition-all absolute left-8 top-0 bg-black/80 backdrop-blur-lg py-2 px-3 rounded-lg text-white text-sm whitespace-nowrap">Private Channel</span>
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-center w-fit">
                    @if ($channel->is_private)
                        <img src="https://api.iconify.design/material-symbols:person.svg?color=%23ffffff" width="20px"> 
                    @endif
                    <p class="text-txt-2 text-sm ml-1">
                        @if ($channel->is_private)
                            {{ $channel->member_count_label }} - 
                        @endif
                        {{ $channel->description }}
                    </p>
                </div>
            </div>
            <div class="mt-4 max-h-178 overflow-y-scroll">
                <div class="space-y-2 sm:[overflow-anchor:none]">
                    @forelse ($chat_messages as $single_message)
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
                                        @can('delete_message', $single_message)
                                            <button x-show="shiftHeld" wire:click="delete({{ $single_message->id }})"  title="Delete the message">
                                                <img src="https://api.iconify.design/material-symbols:delete-outline-sharp.svg?color=%23ef1515" width="18px">
                                            </button>
                                        @endcan
                                        <div class="absolute bg-dark/80 backdrop-blur-sm border border-dark-light-100 rounded-lg p-2 top-8 right-0" style="width: 250px" @click.away="open = false" x-show="open" x-cloak x-transition>
                                            @can('delete_message', $single_message)
                                                <x-buttons.drop-btn wire:click="delete({{ $single_message->id }})" :first='true'>Delete</x-buttons.drop-btn>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                                <p class="text-txt-2 text-sm">{{ $single_message->message }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-txt-2 p-2">Channel is empty</p>
                    @endforelse
                </div>
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
                <div class="flex items-center justify-between mb-3">
                    <h1 class="text-xl text-txt-2 font-semibold">About the channel</h1>
                    @if ($channel->is_private)
                        <strong class="py-1 px-3 ml-2 rounded-lg border border-green-500 text-green-500 text-[10px]">Private</strong>
                    @endif
                </div>
                <div class="border-t border-light">
                    <h2 class="text-2xl text-main font-semibold mb-3 pt-3">#{{ $channel->title }}</h2>
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
            <div wire:loading wire:target="add_user, search, channel_type, create_new_channel, add_new_member, update_profile, new_avatar">
                <x-alert-processing />
            </div>
        </div>
    </nav>
</section>