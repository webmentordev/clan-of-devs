<section x-data="{ open: false }">
    <button @click="open = true" class="bg-white rounded-lg group relative p-2 w-10 h-10 flex items-center justify-center mb-3">
        <img src="https://api.iconify.design/material-symbols:add-rounded.svg?color=%23000000" width="30px">
        <span class="hidden group-hover:block transition-all absolute left-12 top-0 bg-black/80 backdrop-blur-lg py-2 px-3 rounded-lg text-white text-sm whitespace-nowrap z-10">Create a workspace</span>
    </button>
    <div class="w-full h-full fixed top-0 left-0 bg-dark/90 backdrop-blur-md z-10" x-show="open"  x-cloak x-transition>
        <div class="flex items-center justify-center h-full w-full" @click.self="open = false">
            <div class="w-full max-w-sm px-6 sm:px-0">
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="mb-8 text-center">
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Create workspace</h1>
                    </div>
                    <form wire:submit="create" method="POST" class="space-y-5" enctype="multipart/form-data">
                        @session('success')
                            <x-alert-success>{{ $value }}</x-alert-success>
                        @endsession
                        @session('failed')
                            <x-alert-failed>{{ $value }}</x-alert-failed>
                        @endsession

                        <div wire:loading wire:target="create">
                            <x-alert-processing />
                        </div>

                        <div class="mb-3 w-full">
                            <x-label for="title">Workspace name</x-label>
                            <x-input id="title" type="text" wire:model="title" required placeholder="Laravel Developers e.t.c"/>
                            @error('title')
                                <x-error>{{ $message }}</x-error>
                            @enderror
                        </div>
                        <div class="mb-3 w-full">
                            <x-label for="logo">Workspace logo</x-label>
                            <x-input id="logo" type="file" wire:model="logo" accept="image/*" required/>
                            @error('logo')
                                <x-error>{{ $message }}</x-error>
                            @enderror
                        </div>
                        <div class="mb-3 w-full">
                            <x-label for="description">Description</x-label>
                            <x-textarea id="description" rows="6" wire:model="description" required placeholder="Laravel Developers e.t.c"/>
                            @error('description')
                                <x-error>{{ $message }}</x-error>
                            @enderror
                        </div>
                        <div class="mb-3 w-full">
                            <x-label for="category">Workspace category</x-label>
                            <x-select id="category" wire:model="category" required>
                                <option value="" select>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}">{{ $category->title }}</option>
                                @endforeach
                            </x-select>
                            @error('category')
                                <x-error>{{ $message }}</x-error>
                            @enderror
                        </div>
                        <div class="mb-3 w-full">
                            <x-label for="public">Public workspace?</x-label>
                            <x-select id="public" wire:model="public" required>
                                <option value="1">Yes, this will be public</option>
                                <option value="0">No, workspace will be private</option>
                            </x-select>
                            @error('public')
                                <x-error>{{ $message }}</x-error>
                            @enderror
                        </div>
                        <button
                            type="submit"
                            class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                                text-white text-sm font-semibold rounded-lg
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                transition duration-150">
                            Create
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>