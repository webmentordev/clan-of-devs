<nav class="flex flex-col p-3 h-full bg-dark">
    @if (count($workspaces))
        @foreach ($workspaces as $workspace)
            @livewire('components.link', ['route' => 'workspaces', 'id' => $workspace->unique_id, 'name' => $workspace->title, 'logo' => $workspace->logo])
        @endforeach
    @endif
    @livewire('components.create-workspace')
</nav>
