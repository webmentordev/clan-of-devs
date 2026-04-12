<nav class="flex flex-col p-6 h-full border-x border-dark-light-100 bg-dark w-120">
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
                <button class="flex flex-col justify-center items-center">
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
    </div>
</nav>