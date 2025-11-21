         
        @extends('layout.app')
@section('content') 
         
      
    <div class="col-12">
    
        <h1 class="p-3  text-center mt-3">Edit  Post Info</h1>
    </div>
    <div class="col-8 mx-auto">
    <form action="{{ url('posts/'.$post->id) }}" method="POST" class="form border p-3">
        @method('PUT')
        @csrf
 @if ($errors->any())
<div class="alert alert-danger p-1">
<ul>
@foreach ($errors->all() as $error)
<li>  {{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<div class="mb-3">
    <label for="">Post Title</label>
<input type="text" value="{{ $post->title }}" class="form-control" name="title">
</div>

            <div class="mb-3">
    <label for="">Post Description</label>
<textarea class="form-control" name="description"  rows="7">{{ $post->description }}</textarea>
        </div>
                <div class="mb-3" style="display: none;">
    <label for="">Writer</label>
<select name="user_id" class="form-control">
<option value="1">Mostafa</option>
<option value="2">Ali</option>
</select>
</div>
<div class="mb-3">
    <label for="">Post Title</label>
<input type="submit" class="form-control bg-success" value="Save">
</div>
         </form>
           @endsection
