<a href="{{ route($route, $id) }}" wire:navigate class="bg-white rounded-lg group relative p-2 w-10 h-10 flex items-center justify-center mb-3">
    <img src="{{ config('app.url'). '/storage/'. $logo }}" width="20px">
    <span class="hidden group-hover:block transition-all absolute left-12 top-0 bg-black/80 backdrop-blur-lg py-2 px-3 rounded-lg text-white text-sm whitespace-nowrap">{{ $name }}</span>
</a>