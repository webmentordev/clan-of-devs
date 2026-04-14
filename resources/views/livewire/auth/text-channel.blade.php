
<section class="h-screen bg-dark-light flex">
    {{-- Workspace navigation --}}
    @livewire('components.workspace-nav')
    {{-- Workspace channels --}}
    @livewire('components.workspace-channels', ['channels' => $workspace->channels, 'workspace_uid' => $workspace->unique_id, 'channel_uid' => $channel->unique_id])
    {{-- Main workspace channels e.t.c --}}
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
                        @livewire('components.chat-message', ['message' => $single_message])
                    @empty
                        <p class="text-txt-2 p-2">Channel is empty</p>
                    @endforelse
                </div>
            </div>
            <div class="w-full">
                <x-texteditor  placeholder="Message in #{{ $channel->title }}..."
                    wire:model="message"
                    x-on:keydown.enter="if (!$event.shiftKey) { $event.preventDefault(); $wire.send_message() }">
                </x-texteditor>
            </div>  
        </section>
    {{-- Workspace channel information --}}
    @livewire('components.workspace-channel-info', ['channel' => $channel])
</section>