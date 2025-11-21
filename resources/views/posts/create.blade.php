         
        @extends('layout.app')
@section('content') 
         
      
    <div class="col-12">
    
        <h1 class="p-3  text-center mt-3">Add Posts</h1>
    </div>
    <div class="col-8 mx-auto">
    <form action="{{url('posts')}}" method="POST" class="form border p-3">
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

@if (session()->get('success') !=null)
<h3 class=" text-success my-2">{{ session()->get('success') }}</h3>
@endif

<div class="mb-3">
    <label for="">Post Title</label>
<input type="text" class="form-control" value="{{ old('title') }}" name="title">
</div>

            <div class="mb-3">
    <label for="">Post Description</label>
<textarea class="form-control" name="description"  rows="7">{{ old('description') }}</textarea>
        </div>
<div class="mb-3">
<input type="submit" class="form-control bg-success" value="Save">
</div>
         </form>
           @endsection
