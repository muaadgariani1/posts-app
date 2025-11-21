<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Posts App' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 text-slate-900 antialiased">
    <!-- Navbar -->
    <nav class="border-b border-slate-200 bg-white/80 backdrop-blur">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <div class="flex items-center gap-6">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <span class="text-lg font-semibold tracking-tight bg-gradient-to-r from-sky-400 via-cyan-400 to-blue-500 bg-clip-text text-transparent">
                        PostsApp
                    </span>
                </a>

                <div class="hidden md:flex items-center gap-4 text-sm text-slate-600">
                    <a href="{{ route('posts.index') }}"
                       class="hover:text-slate-900 {{ request()->routeIs('posts.*') ? 'font-semibold text-slate-900' : '' }}">
                        Posts
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="hover:text-slate-900 {{ request()->routeIs('dashboard') ? 'font-semibold text-slate-900' : '' }}">
                            My Posts
                        </a>

                        @can('view-admin-dashboard')
                            <a href="{{ route('admin.dashboard') }}"
                               class="hover:text-slate-900 {{ request()->routeIs('admin.*') ? 'font-semibold text-slate-900' : '' }}">
                                Admin
                            </a>
                        @endcan
                    @endauth
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- Search -->
                <form action="{{ route('posts.search') }}" method="GET" class="hidden sm:flex items-center">
                    <div class="relative">
                        <input
                            type="search"
                            name="q"
                            placeholder="Search posts..."
                            class="w-48 lg:w-64 rounded-full bg-sky-50 border border-sky-200 px-4 py-1.5 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        >
                    </div>
                </form>

                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="text-sm px-3 py-1.5 rounded-full border border-slate-300 text-slate-700 hover:border-slate-400 hover:text-slate-900 transition"
                        >
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm px-3 py-1.5 rounded-full border border-slate-300 text-slate-700 hover:border-slate-400 hover:text-slate-900 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="hidden sm:inline-flex text-sm px-3 py-1.5 rounded-full bg-sky-600 hover:bg-sky-500 text-white transition shadow-sm">
                        Sign up
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash success --}}
            @if (session('success'))
                <div class="mb-4 rounded-lg border border-emerald-500/60 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-500/60 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <div class="font-medium mb-1">There were some problems with your input:</div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-xs text-slate-500 flex justify-between">
            <span>© {{ date('Y') }} PostsApp</span>
            <span>Built with Laravel & Tailwind</span>
        </div>
    </footer>
</body>
</html>
