@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-slate-900 mb-2">
        Create New Post
    </h1>
    <p class="text-sm text-slate-600 mb-6">
        Share your thoughts with everyone. You can always edit later.
    </p>

    <form action="{{ route('posts.store') }}" method="POST"
          class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @include('posts._form')
    </form>
</div>
@endsection
