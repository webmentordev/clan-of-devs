<nav class="flex flex-col p-3 h-full bg-dark">
    @if (count($workspaces))
        @foreach ($workspaces as $workspace)
            @livewire('components.link', ['route' => 'text.channel', 'id' => $workspace->unique_id, 'name' => $workspace->title, 'channel' => $workspace->general_chat->unique_id, 'logo' => $workspace->logo])
        @endforeach
    @endif
    @livewire('components.create-workspace')
</nav>
