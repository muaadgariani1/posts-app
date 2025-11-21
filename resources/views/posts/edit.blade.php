         
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-slate-900 mb-2">
        Edit Post
    </h1>
    <p class="text-sm text-slate-600 mb-6">
        Update your post details below.
    </p>

    <form action="{{ route('posts.update', $post) }}" method="POST"
          class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        @method('PUT')
        @csrf
        @include('posts._form')
    </form>
</div>
@endsection
