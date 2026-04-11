<nav class="flex flex-col p-3 h-full border-x border-dark-light-100 w-85 overflow-y-scroll">
    <div class="w-full flex items-center mb-2">
        <img src="https://api.iconify.design/cuida:caret-down-outline.svg?color=%23888888" width="20px">
        <span class="ml-2 text-white font-semibold text-sm">Workspace categories</span>
    </div>
    @foreach ($categories as $category)
        @php
            $count = $category->workspaces_count;
        @endphp
    <a href="{{ route('workspaces', $category->slug) }}" wire:navigate class="hover border-l-4 border-transparent hover:border-main flex items-center text-sm text-txt-2 mb-1 py-1 px-2 w-full justify-between"><strong class="ml-2">{{ Str::limit($category->title, 30) }}</strong><span class="@if ($count > 0) text-main @else text-white @endif">{{ number_format($count)}}</span></a>
    @endforeach
</nav>