         
@extends('layout.app')
@section('content')

<div class="col-12">
    <h1 class="p-3 border text-center mt-3">All Posts</h1>
</div>
@auth
<div class="col-12">
    <a href="{{ route('posts.create') }}" class="btn btn-sm btn-primary float-start mb-2">Add New Post</a>
    <div class="clearfix"></div>
</div>
@endauth
@foreach ($posts as $post )

    <div class="col-12">
                <div class="card">
  <div class="card-header">
  {{ $post->user->name }} - {{ $post->created_at->format ('Y-n-d') }}
</div>
  
  <div class="card-body">
    <h5 class="card-title">{{$post->title}}</h5>
    <p class="card-text">{{\Str::limit($post->description,50)}}.</p>
    <a href="{{ url('posts/'.$post->id) }}" class="btn btn-primary">Show Post</a>
     </div>
      </div>   
   </div>
    
        @endforeach
<div>
  {{ $posts->links() }}
</div>
           @endsection
