
<section class="h-screen bg-dark-light flex">
    {{-- Workspace navigation --}}
    @livewire('components.workspace-nav')
    {{-- Workspace categories --}}
    @livewire('components.workspace-categories')
    {{-- Main workspace channels e.t.c --}}
    <section class="w-full h-full p-2">
        @forelse ($workspaces as $workspace)
            <div class="flex flex-wrap">
                <div wire:click='assign_data("{{ $workspace->unique_id }}")' class="flex flex-col w-full h-fit max-w-[200px] bg-dark-light-100 rounded-xl overflow-hidden border border-white/5 cursor-pointer">
                    <div class="flex items-center justify-center bg-dark-100 h-32 p-4">
                        <img src="{{ config('app.url') . '/storage/' . $workspace->logo }}" class="w-16 h-16 object-contain rounded-xl" alt="{{ $workspace->title }}">
                    </div>
                    <div class="flex flex-col p-4 gap-3">
                        <div>
                            <h3 class="text-white font-semibold text-[15px] leading-snug">{{ $workspace->title }}</h3>
                            <p class="text-txt-2 text-xs mt-1 leading-relaxed">{{ Str::limit($workspace->description, 60, '...') }}</p>
                        </div>
                        <div class="flex items-center gap-1.5 py-2.5 border-y border-white/6">
                            <img src="https://api.iconify.design/lucide:users.svg?color=%236b7280" class="w-3.5 h-3.5" alt="">
                            @php $members = $workspace->members_count; @endphp
                            <span class="text-txt-2 text-xs">{{ $members }} {{ Str::plural('member', $members) }}</span>
                        </div>
                        <button wire:click='join_workspace("{{ $workspace->unique_id }}")' class="w-full bg-main hover:bg-main/80 text-white text-sm font-semibold py-2.5 rounded-lg transition-opacity duration-150">
                            Join workspace
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="w-full h-full flex items-center justify-center">
                <h1 class="text-white">Workspaces do not exist!</h1>
            </div>
        @endforelse
    </section>
    @if ($workspace_data)
        {{-- Workspace information --}}
        @livewire('components.workspace-info', ['data' => $workspace_data])
    @endif
</section>