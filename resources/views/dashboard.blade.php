@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-slate-900">
            My Posts
        </h1>
        <p class="text-sm text-slate-600 mt-1">
            Manage everything you’ve written in one place.
        </p>
    </div>

    <a href="{{ route('posts.create') }}"
       class="inline-flex items-center gap-2 rounded-full bg-sky-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-sky-500 transition">
        <span class="text-lg">＋</span>
        New Post
    </a>
</div>

@if ($posts->isEmpty())
    <div class="rounded-xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">
        You haven't written anything yet. Start with your first post!
    </div>
@else
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3 hidden md:table-cell">Excerpt</th>
                    <th class="px-4 py-3">Created</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($posts as $post)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-slate-900">
                            <a href="{{ route('posts.show', $post) }}" class="hover:text-sky-700">
                                {{ $post->title }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-slate-600 hidden md:table-cell">
                            {{ \Str::limit($post->description, 60) }}
                        </td>
                        <td class="px-4 py-3 text-slate-500">
                            {{ $post->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
@endif
@endsection
