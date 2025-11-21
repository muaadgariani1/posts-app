

@extends('layout.app')
@section('content')


         <div class="col-12"></div>
         <div class="row">
    <div class="col-12">
        <h1 class="p-3 border text-center mt-3">All Posts</h1>
        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search all posts..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>
    </div>
</div>
@if (session()->get('success') !=null)
<h3 class=" text-success my-2">{{ session()->get('success') }}</h3>
@endif
<table class="table table-bordered">
<th>
<tr>
    <th>#</th>
        <th>Title</th>
    <th>Description</th>
    <th>Writer</th>
    <th>Edit</th>
    <th>Delete</th>

</tr>


</th>
<tbody>
@foreach ($posts as $post)

<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$post->title}}</td>
    <td>{{ $post->description }}</td>
    <td>{{$post->user->name}}</td>
    <td>
        @auth
            @if($post->user_id == auth()->id())
                <a href="{{url('posts/'. $post->id . '/edit') }}" class="btn btn-info">Edit</a>
            @else
                N/A
            @endif
        @else
            N/A
        @endauth
    </td>
    <td>
        @auth
            @if($post->user_id == auth()->id())
                <form action="{{ url('posts/'. $post->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="submit" value="Delete" class="btn btn-danger">
                </form>
            @else
                N/A
            @endif
        @else
            N/A
        @endauth
    </td>
</tr>
@endforeach
</tbody>
</table>
<div>

{{ $posts->links() }}
</div>
   </div>
   @endsection
