<nav class="flex flex-col p-3 h-full border-x border-dark-light-100 w-80">
    <div class="" x-data="{ open: false }">
        <button class="w-full flex items-center mb-3">
            <img src="https://api.iconify.design/cuida:caret-down-outline.svg?color=%23888888" width="20px">
            <span class="ml-2 text-white font-semibold text-sm">Text channels</span>
        </button>
        <div class="flex flex-col">
            <a href="{{ route('text.channel', ['laravel134', 'general']) }}" class="text-sm text-txt-2 font-semibold border-r-4 border-main bg-dark py-1 px-2 w-full"># general</a>
        </div>
    </div>
</nav>