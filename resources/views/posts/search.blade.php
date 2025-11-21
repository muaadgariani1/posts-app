@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-slate-900">
        Search Results
    </h1>
    <p class="text-sm text-slate-600 mt-1">
        Showing results for your query.
    </p>
</div>

@if ($posts->isEmpty())
    <div class="rounded-xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">
        No posts matched your search.
    </div>
@else
    <div class="space-y-4">
        @foreach ($posts as $post)
            <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:shadow-md transition">
                <header class="flex items-center justify-between text-xs text-slate-500 mb-2">
                    <span>{{ $post->user->name }}</span>
                    <span>{{ $post->created_at->format('Y-m-d') }}</span>
                </header>

                <h2 class="text-lg font-semibold text-slate-900">
                    {{ $post->title }}
                </h2>

                <p class="mt-2 text-sm text-slate-600">
                    {{ \Str::limit($post->description, 120) }}
                </p>

                <div class="mt-3">
                    <a href="{{ route('posts.show', $post) }}"
                       class="text-sm font-medium text-sky-600 hover:text-sky-700">
                        Show Post →
                    </a>
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection
