@php
    $isEdit = isset($post);
@endphp

<div class="space-y-5">
    <div>
        <label for="title" class="block text-sm font-medium text-slate-800 mb-1">
            Title
        </label>
        <input
            id="title"
            type="text"
            name="title"
            value="{{ old('title', $post->title ?? '') }}"
            class="block w-full rounded-xl border border-sky-200 bg-sky-50 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
            placeholder="Give your post a clear, catchy title"
            required
        >
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-slate-800 mb-1">
            Content
        </label>
        <textarea
            id="description"
            name="description"
            rows="7"
            class="block w-full rounded-xl border border-sky-200 bg-sky-50 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
            placeholder="Write your post here..."
            required
        >{{ old('description', $post->description ?? '') }}</textarea>
        <p class="mt-1 text-xs text-slate-500">
            Up to 1500 characters.
        </p>
    </div>

    <div class="flex items-center justify-between gap-3">
        <a href="{{ url()->previous() }}"
           class="text-sm rounded-full border border-slate-300 px-4 py-2 text-slate-700 hover:border-slate-400 hover:text-slate-900 transition">
            Cancel
        </a>

        <button
            type="submit"
            class="inline-flex items-center rounded-full bg-sky-600 px-5 py-2 text-sm font-medium text-white hover:bg-sky-500 shadow-sm transition">
            {{ $isEdit ? 'Update Post' : 'Publish Post' }}
        </button>
    </div>
</div>
