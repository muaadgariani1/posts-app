@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">
                Welcome back
            </h1>
            <p class="mt-1 text-sm text-slate-600">
                Sign in to continue posting and managing your content.
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-emerald-500/60 bg-emerald-50 px-4 py-2 text-sm text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

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
                        autofocus
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

                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-slate-600">
                        <input
                            type="checkbox"
                            name="remember"
                            class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <span>Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sky-600 hover:text-sky-700">
                            Forgot your password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center rounded-full bg-sky-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-sky-500 transition"
                    >
                        Log in
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-4 text-center text-xs text-slate-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-medium text-sky-600 hover:text-sky-700">
                Create one
            </a>
        </p>
    </div>
</div>
@endsection
