@extends('layout.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="p-3 border text-center mt-3">My Posts</h1>
            <p>Welcome to your dashboard, {{ auth()->user()->name }}!</p>
            <a href="{{ route('posts.create') }}" class="btn btn-success mb-3">Create New Post</a>
            @if (session()->get('success') != null)
                <h3 class="text-success my-2">{{ session()->get('success') }}</h3>
            @endif
            @foreach ($posts as $post)
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            {{ $post->user->name }} - {{ $post->created_at->format('Y-n-d') }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ \Str::limit($post->description, 50) }}.</p>
                            <a href="{{ url('posts/' . $post->id) }}" class="btn btn-primary">Show Post</a>
                            <a href="{{ url('posts/' . $post->id . '/edit') }}" class="btn btn-info">Edit</a>
                            <form action="{{ url('posts/' . $post->id) }}" method="POST" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <input type="submit" value="Delete" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            <div>
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
