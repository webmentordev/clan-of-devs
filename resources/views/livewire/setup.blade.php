<section class="bg-dark h-screen">
    <div class="flex items-center justify-center h-full w-full">
            <div class="w-full max-w-sm px-6 sm:px-0">
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="mb-8 text-center">
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Setup admin account!</h1>
                    </div>
                    <form wire:submit="create_user" method="POST" class="space-y-5">
                        @session('failed')
                            <x-alert-failed>{{ $value }}</x-alert-failed>
                        @endsession
                        <div wire:loading wire:target="create_user">
                            <x-alert-processing />
                        </div>
                        <div class="w-full">
                            <x-label for="name">Full name</x-label>
                            <x-input id="name" type="text" wire:model="name" required placeholder="John Doe"/>
                            @error('name')
                                <x-error>{{ $message }}</x-error>
                            @enderror
                        </div>

                        <div class="w-full">
                            <x-label for="email" >Email address</x-label>
                            <x-input id="email" type="email" wire:model="email" required placeholder="you@example.com" />
                            @error('email')
                                <x-error>{{ $message }}</x-error>
                            @enderror
                        </div>

                        <div class="w-full">
                            <x-label for="password">Password</x-label>
                            <x-input id="password" type="password" wire:model="password" required placeholder="••••••••" />
                            @error('password')
                                <x-error>{{ $message }}</x-error>
                            @enderror
                        </div>

                        <div class="w-full">
                            <x-label for="password_confirmation">Confirm password</x-label>
                            <x-input id="password_confirmation" type="password" wire:model="password_confirmation" required placeholder="••••••••" />
                            @error('password_confirmation')
                                <x-error>{{ $message }}</x-error>
                            @enderror
                        </div>
                        <p class="text-sm">Default channels will be created automatically.</p>
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
</section>