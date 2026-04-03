@extends('layouts.auth')

@section('content')
    <div class="min-h-screen w-full flex items-center justify-center">
        <div class="w-full max-w-sm px-6 sm:px-0">
            <div class="bg-white rounded-2xl shadow-lg p-8">

                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Forgot password</h1>
                    <p class="text-sm text-gray-500 mt-1">Enter your email and we'll send you a reset link.</p>
                </div>

                <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                    @csrf

                    @session('status')
                        <x-alert-success>{{ $value }}</x-alert-success>
                    @endsession

                    @session('error')
                        <x-alert-failed>{{ $value }}</x-alert-failed>
                    @endsession

                    <div>
                        <x-label for="email">Email address</x-label>
                        <x-input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com" />
                        @error('email')
                            <x-error>{{ $message }}</x-error>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                               text-white text-sm font-semibold rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               transition duration-150">
                        Send reset link
                    </button>
                </form>

                @if (Route::has('login'))
                    <p class="mt-6 text-center text-sm text-gray-500">
                        Remembered it?
                        <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Back to sign in</a>
                    </p>
                @endif

            </div>
        </div>
    </div>
@endsection