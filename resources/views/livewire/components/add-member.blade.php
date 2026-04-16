<section class="" x-data="{ open: false }">
    <button @click="open = true">
        <img src="https://api.iconify.design/material-symbols:add-2-rounded.svg?color=%23ffa0a1" width="20px">
    </button>
    <div class="z-50 top-0 left-0 bg-dark/10 backdrop-blur-lg w-full h-full fixed" x-show="open" x-cloak x-transition>
        <div class="w-full h-full flex items-center justify-center" @click.self="open = false">
            <div class="max-w-2xl w-full p-6 bg-dark border border-white/10 rounded-lg">
                <h3 class="text-white mb-3">Add a new member</h3>
                @session('success')
                    <x-alert-success>{{ $value }}</x-alert-success>
                @endsession
                @session('failed')
                    <p class="my-3 text-main bg-main/10 p-3 rounded-lg border border-main">{{ $value }}</p>
                @endsession
                <x-input class="border-none bg-dark-100 text-white mb-3" wire:model.live.debouce.1000ms="search" placeholder="Search by email or username" />
                @foreach ($users as $user)
                    <div class="flex items-center justify-between">
                        <x-cards.mini-profile :name="$user->name" :avatar="$user->get_avatar()" />
                        <button wire:click='add("{{ $user->username }}")' class="py-1 px-3 rounded-lg bg-main text-white text-sm">Add</button>
                    </div>
                @endforeach
                @if ($usersCount != 0)
                    <p class="text-main text-sm text-center my-3 pt-3 border-t border-main/10"> {{ $usersCount }} {{ Str::plural('user', $usersCount) }} found. </p>
                @endif
            </div>
        </div>
        <div wire:loading wire:target="add">
            <x-alert-processing />
        </div>
    </div>
</section>
