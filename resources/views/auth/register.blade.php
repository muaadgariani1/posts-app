@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">
                Create an account
            </h1>
            <p class="mt-1 text-sm text-slate-600">
                Join the community and start writing your posts.
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-800 mb-1">
                        Name
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="block w-full rounded-xl border border-sky-200 bg-sky-50 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        placeholder="Your name"
                    >
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-800 mb-1">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="block w-full rounded-xl border border-sky-200 bg-sky-50 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        placeholder="you@example.com"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-800 mb-1">
                        Password
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="block w-full rounded-xl border border-sky-200 bg-sky-50 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-800 mb-1">
                        Confirm Password
                    </label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        class="block w-full rounded-xl border border-sky-200 bg-sky-50 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        placeholder="Repeat your password"
                    >
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center rounded-full bg-sky-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-sky-500 transition"
                    >
                        Sign up
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-4 text-center text-xs text-slate-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-sky-600 hover:text-sky-700">
                Log in
            </a>
        </p>
    </div>
</div>
@endsection
