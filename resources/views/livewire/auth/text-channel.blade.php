
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
                        <div class="relative group">
                            <img src="https://api.iconify.design/iconamoon:lock-bold.svg?color=%2315ef57" width="22px" class="ml-2">
                            <span class="hidden group-hover:block transition-all absolute left-8 top-0 bg-black/80 backdrop-blur-lg py-2 px-3 rounded-lg text-white text-sm whitespace-nowrap">Private Channel</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center w-fit">
                        <img src="https://api.iconify.design/material-symbols:person.svg?color=%23ffffff" width="20px">
                        <p class="text-txt-2 text-sm ml-1">120 members - Main reason for this channel is to receive fresh updates on all kind of work</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex">
                        <img src="{{ asset('assets/avatar.png') }}" width="40px" height="40px" class="object-fill rounded-full w-10 h-10">
                        <div class="flex flex-col ml-3">
                            <div class="flex items-center">
                                <h3 class="text-white text-lg">Jon Williumson Starmer</h3>
                                <span class="ml-3 text-txt-1 text-sm">10:38 AM</span>
                            </div>
                            <p class="text-txt-2 text-sm">Google Messages is the official Google app for messaging. Google Messages is revolutionizing how a billion users connect and is powered by Rich</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-dark rounded-lg p-4">

            </div>
        </section>
    {{-- Workspace channel information --}}
    @livewire('components.workspace-channel-info')
</section>