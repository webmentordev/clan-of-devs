<div class="flex mb-2 p-2 group hover:bg-dark-100 transition-all rounded-md" x-data="{ open: false, shiftHeld: false }"  
    @keydown.shift.window="shiftHeld = true" 
    @keyup.shift.window="shiftHeld = false">
    <img src="{{ $message->user->get_avatar() }}" width="40px" height="40px" class="object-fill rounded-full w-10 h-10">
    <div class="flex flex-col ml-3 w-full">
        <div class="flex justify-between w-full">
            <div class="flex items-center">
                <h3 class="text-white text-lg">{{ $message->user->name }}</h3>
                <span class="ml-3 text-txt-1 text-sm">{{ $message->created_at->format('d M, y h:i A') }}</span>
            </div>
            <div class="relative hidden group-hover:block">
                <button class="py-0.5 px-2 rounded-md bg-dark-100 border border-dark-light-100" @click="open = true">
                    <img src="https://api.iconify.design/mdi:dots-horizontal.svg?color=%23e3e3e3" width="18px">
                </button>
                <button x-show="shiftHeld" wire:click="delete" title="Delete the message">
                    <img src="https://api.iconify.design/material-symbols:delete-outline-sharp.svg?color=%23ef1515" width="18px">
                </button>
                <div class="absolute bg-dark/80 backdrop-blur-sm border border-dark-light-100 rounded-lg p-2 top-8 right-0" style="width: 250px" @click.away="open = false" x-show="open" x-cloak x-transition>
                    <x-buttons.drop-btn wire:click="delete" :first='true'>Delete</x-buttons.drop-btn>
                </div>
            </div>
        </div>
        <p class="text-txt-2 text-sm">{{ $message->message }}</p>
    </div>
</div>