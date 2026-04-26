@extends('layouts.auth')
@section('content')
    <div class="min-h-screen w-full flex items-center justify-center">
        <div class="w-full max-w-sm px-6 sm:px-0">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Welcome back</h1>
                    <p class="text-sm text-gray-500 mt-1">Sign in to your account</p>
                </div>
                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    @session('success')
                        <x-alert-success>{{ $value }}</x-alert-success>
                    @endsession
                    @session('failed')
                        <x-alert-failed>{{ $value }}</x-alert-failed>
                    @endsession
                    <div>
                        <x-label for="email">Email address</x-label>
                        <x-input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com"/>
                        @error('email')
                            <x-error>{{ $message }}</x-error>
                        @enderror
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <x-label for="password">Password</x-label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-xs text-blue-600 hover:text-blue-500 hover:underline">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        <x-input id="password" type="password" name="password" required placeholder="••••••••" />
                        @error('password')
                            <x-error>{{ $message }}</x-error>
                        @enderror
                    </div>
                    <div class="flex items-center">
                        <input
                            id="remember"
                            type="checkbox"
                            name="remember_me"
                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        />
                        <label for="remember" class="ml-2 text-sm text-gray-600">
                            Remember me
                        </label>
                    </div>
                    <button
                        type="submit"
                        class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                               text-white text-sm font-semibold rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               transition duration-150">
                        Sign in
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection