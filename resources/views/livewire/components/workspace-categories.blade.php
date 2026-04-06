<nav class="flex flex-col p-3 h-full border-x border-dark-light-100 w-85 overflow-y-scroll">
    <div class="w-full flex items-center mb-2">
        <img src="https://api.iconify.design/cuida:caret-down-outline.svg?color=%23888888" width="20px">
        <span class="ml-2 text-white font-semibold text-sm">Workspace categories</span>
    </div>
    @foreach ($categories as $category)
        <a href="{{ route('workspaces', $category->slug) }}" wire:navigate class="hover border-l-4 border-transparent hover:border-main flex items-center text-sm text-txt-2 font-semibold mb-1 py-1 px-2 w-full"><strong class="ml-2">{{ $category->title }}</strong></a>
    @endforeach
</nav>