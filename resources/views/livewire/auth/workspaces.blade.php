
<section class="h-screen bg-dark-light flex">
    {{-- Workspace navigation --}}
    @livewire('components.workspace-nav')
    {{-- Main workspace channels e.t.c --}}
        <section class="w-full h-full p-2 flex flex-col justify-between">
        </section>
    {{-- Workspace channel information --}}
    @livewire('components.workspace-channel-info')
</section>