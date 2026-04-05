<nav class="flex flex-col p-3 h-full border-x border-dark-light-100 w-80">
    <div class="" x-data="{ text_open: true, voice_open: true }">
        <button class="w-full flex items-center mb-2" @click="text_open = !text-open">
            <img src="https://api.iconify.design/cuida:caret-down-outline.svg?color=%23888888" width="20px">
            <span class="ml-2 text-white font-semibold text-sm">Text channels</span>
        </button>
        <div class="flex flex-col">
            @foreach ($channels as $channel)
                @if($channel->type == 'text')
                    <a href="{{ route('text.channel', [$workspace_uid, $channel->unique_id]) }}" wire:navigate class="flex items-center text-sm text-txt-2 font-semibold mb-1 
                    @if ($channel_uid == $channel->unique_id)
                        border-main bg-dark border-r-4
                    @endif py-1 px-2 w-full"> 
                    @if (!$channel->is_private)
                        <img src="https://api.iconify.design/clarity:hashtag-solid.svg?color=%23e3e3e3" width="13"> <strong class="ml-2"></strong>
                    @else
                        <img src="https://api.iconify.design/material-symbols-light:lock.svg?color=%23e3e3e3" width="17">
                    @endif {{ $channel->title }}</strong></a>
                @endif
            @endforeach
        </div>

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
    </div>
</nav>