@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-slate-900">
            All Posts
        </h1>
        <p class="text-sm text-slate-600 mt-1">
            Explore posts from the community. Click a post to read more.
        </p>
    </div>
</div>

@if ($posts->isEmpty())
    <div class="rounded-xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">
        No posts yet. Be the first to publish something!
    </div>
@else
    <div class="grid gap-5 md:grid-cols-2">
        @foreach ($posts as $post)
            <article class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
                    <span>{{ $post->user->name }}</span>
                    <span>{{ $post->created_at->format('Y-m-d') }}</span>
                </div>

                <h2 class="text-lg font-semibold text-slate-900 group-hover:text-sky-700 transition line-clamp-2">
                    {{ $post->title }}
                </h2>

                <p class="mt-2 text-sm text-slate-600 line-clamp-3">
                    {{ \Str::limit($post->description, 150) }}
                </p>

                <div class="mt-4 flex items-center justify-between">
                    <a href="{{ route('posts.show', $post) }}"
                       class="text-sm font-medium text-sky-600 hover:text-sky-700">
                        Read more →
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
        @endforeach
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
@endif
@endsection
