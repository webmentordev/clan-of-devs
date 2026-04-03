<nav class="flex flex-col p-3 h-full border-x border-dark-light-100 w-80">
    <div class="" x-data="{ text_open: true, voice_open: true }">
        <button class="w-full flex items-center mb-2" @click="text_open = !text-open">
            <img src="https://api.iconify.design/cuida:caret-down-outline.svg?color=%23888888" width="20px">
            <span class="ml-2 text-white font-semibold text-sm">Text channels</span>
        </button>
        <div class="flex flex-col">
            <a href="{{ route('text.channel', ['laravel134', 'general']) }}" class="flex items-center text-sm text-txt-2 font-semibold border-r-4 mb-1 border-main bg-dark py-1 px-2 w-full"><img src="https://api.iconify.design/clarity:hashtag-solid.svg?color=%23e3e3e3" width="13"> <strong class="ml-2">general</strong></a>
            <a href="{{ route('text.channel', ['laravel134', 'general']) }}" class="flex items-center text-sm text-txt-2 font-semibold border-r-4 mb-1 border-main bg-dark py-1 px-2 w-full"><img src="https://api.iconify.design/material-symbols-light:lock.svg?color=%23e3e3e3" width="17"> <strong class="ml-2">discussion</strong></a>
        </div>

        <button class="w-full flex items-center mb-2 mt-8" @click="voice_open = !text-open">
            <img src="https://api.iconify.design/cuida:caret-down-outline.svg?color=%23888888" width="20px">
            <span class="ml-2 text-white font-semibold text-sm">Voice channels</span>
        </button>
        <div class="flex flex-col">
            <a href="{{ route('text.channel', ['laravel134', 'general']) }}" class="flex items-center text-sm text-txt-2 font-semibold border-r-4 mb-1 border-main bg-dark py-1 px-2 w-full"><img src="https://api.iconify.design/mdi:volume-high.svg?color=%23e3e3e3" width="16"> <strong class="ml-2">general-chat</strong></a>
        </div>
    </div>
</nav>