         
@extends('layout.app')
@section('content')

<div class="col-12">
    <h1 class="p-3 border text-center mt-3">Search Results</h1>
</div>

@foreach ($posts as $post)
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{ $post->user->name }} - {{ $post->created_at->format('Y-n-d') }}
            </div>

            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ \Str::limit($post->description, 50) }}.</p>
                <a href="{{ url('posts/' . $post->id) }}" class="btn btn-primary">Show Post</a>
            </div>
        </div>
    </div>
@endforeach

@endsection
