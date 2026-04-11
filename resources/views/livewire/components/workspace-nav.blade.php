<nav class="flex flex-col p-3 h-full bg-dark">
    <a href="{{ route('workspaces') }}" wire:navigate class="bg-dark-100 border border-main/50 rounded-lg group relative p-2 w-10 h-10 flex items-center justify-center mb-3">
        <img src="https://api.iconify.design/carbon:workspace.svg?color=%23f66da5" width="20px">
        <span class="hidden group-hover:block transition-all absolute left-12 top-0 bg-black/80 backdrop-blur-lg py-2 px-3 rounded-lg text-white text-sm whitespace-nowrap">Workspaces</span>
    </a>
    <div class="border-t border-white/10 mt-1 mb-3 inline-block"></div>
    @if (count($workspaces))
        @foreach ($workspaces as $workspace)
            @livewire('components.link', ['route' => 'text.channel', 'id' => $workspace->unique_id, 'name' => $workspace->title, 'channel' => $workspace->general_chat->unique_id, 'logo' => $workspace->logo])
        @endforeach
    @endif
    @livewire('components.create-workspace')
</nav>
