@extends('layouts.auth')

@section('content')
    <div class="min-h-screen w-full flex items-center justify-center">
        <div class="w-full max-w-sm px-6 sm:px-0">
            <div class="bg-white rounded-2xl shadow-lg p-8">

                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Create an account</h1>
                    <p class="text-sm text-gray-500 mt-1">Sign up to get started</p>
                </div>

                @if (session('error'))
                    <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf
                    @session('success')
                        <x-alert-success>{{ $value }}</x-alert-success>
                    @endsession
                    @session('failed')
                        <x-alert-failed>{{ $value }}</x-alert-failed>
                    @endsession
                    <div>
                        <x-label for="name">Full name</x-label>
                        <x-input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe"/>
                        @error('name')
                            <x-error>{{ $message }}</x-error>
                        @enderror
                    </div>

                    <div>
                        <x-label for="username">Username</x-label>
                        <x-input id="username" type="text" name="username" value="{{ old('username') }}" required placeholder="johndoe" />
                        @error('username')
                            <x-error>{{ $message }}</x-error>
                        @enderror
                    </div>

                    <div>
                        <x-label for="email" >Email address</x-label>
                        <x-input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com" />
                        @error('email')
                            <x-error>{{ $message }}</x-error>
                        @enderror
                    </div>

                    <div>
                        <x-label for="password">Password</x-label>
                        <x-input id="password" type="password" name="password" required placeholder="••••••••" />
                        @error('password')
                            <x-error>{{ $message }}</x-error>
                        @enderror
                    </div>

                    <div>
                        <x-label for="password_confirmation">Confirm password</x-label>
                        <x-input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" />
                        @error('password_confirmation')
                            <x-error>{{ $message }}</x-error>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                               text-white text-sm font-semibold rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               transition duration-150">
                        Create account
                    </button>
                </form>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs text-gray-400">
                        <span class="bg-white px-3">or continue with</span>
                    </div>
                </div>

                <form action="{{ route('google.redirect') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center gap-3 px-5 py-2.5
                               bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700
                               hover:bg-gray-50 active:bg-gray-100
                               focus:outline-none focus:ring-2 focus:ring-gray-300
                               transition duration-150 shadow-sm">
                        <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512">
                            <path fill="#4285F4" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/>
                        </svg>
                        Sign up with Google
                    </button>
                </form>

                @if (Route::has('login'))
                    <p class="mt-6 text-center text-sm text-gray-500">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Sign in</a>
                    </p>
                @endif

            </div>
        </div>
    </div>
@endsection