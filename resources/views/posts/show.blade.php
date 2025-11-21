@extends('layouts.app')

@section('content')
<article class="max-w-3xl mx-auto">
    <header class="mb-6">
        <div class="text-xs text-slate-500 mb-2 flex items-center gap-2">
            <span>{{ $post->user->name }}</span>
            <span class="h-1 w-1 rounded-full bg-slate-300"></span>
            <span>{{ $post->created_at->format('Y-m-d') }}</span>
        </div>

        <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-slate-900">
            {{ $post->title }}
        </h1>
    </header>

    <div class="prose prose-slate max-w-none">
        <p class="whitespace-pre-line text-slate-800">
            {{ $post->description }}
        </p>
    </div>

    <div class="mt-8 flex items-center justify-between">
        <a href="{{ url()->previous() }}"
           class="text-sm text-slate-600 hover:text-slate-900">
            ← Back
        </a>

        @auth
            @if ($post->user_id === auth()->id())
                <div class="flex items-center gap-2">
                    <a href="{{ route('posts.edit', $post) }}"
                       class="text-xs rounded-full border border-slate-300 px-3 py-1 text-slate-700 hover:border-sky-500 hover:text-sky-700 transition">
                        Edit
                    </a>

                    <form action="{{ route('posts.destroy', $post) }}" method="POST"
                          onsubmit="return confirm('Delete this post?')">
                        @csrf
                        @method('DELETE')
                        <button
                            class="text-xs rounded-full border border-red-500/70 px-3 py-1 text-red-600 hover:bg-red-50 transition">
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</article>
@endsection
