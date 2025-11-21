<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
{
    public function index()
    {
        $query = Post::with('user');

        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $posts = $query->paginate();
        return view("posts.index", ["posts"=> $posts]);
    }
public function home()
    {
        $posts = Post::where('user_id', auth()->id())->with('user')->paginate();
        return view("dashboard", ["posts"=> $posts]);
    }




    public function create()
    {
        return view("posts.create");
    }

     public function store(Request $request)
    {
        $request->validate([
            'title'=> ['required','string','min:3'],
            'description'=> ['required','string','max:1500'],
        ]);

      $post= new Post();
      $post->title = $request->title;
       $post->description = $request->description;
       $post->user_id = auth()->id();
       $post->published = 1;
       $post->save();
       return redirect('/dashboard')->with('success','Post Added Successfully');
       // dd(request()->all());
    }
    public function show($id)
    {
         $post = Post::findOrFail( $id );
        return view("posts.show", ["post"=> $post]);
    }
 public function search(Request $request)
    {

        $q=$request->q;
        $posts = Post::where('description','like','%'.$q.'%')->get();
        return view('posts.search', ['posts' => $posts]);
    }


        public function edit($id)
    {
        $post = Post::findOrFail( $id );
        return view("posts.edit", ["post"=> $post]);
    }

     public function update($id, Request $request)
{
    $request->validate([
        'title' => ['required', 'string', 'min:3'],
        'description' => ['required', 'string', 'max:1500'],
    ]);

    $post = Post::findOrFail($id);
    if ($post->user_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }
    $post->title = $request->title;
    $post->description = $request->description;
    $post->save();

    return redirect('posts')->with("success","Post Updated Successfully");
}








    public function destroy($id)
    {
        $post = Post::findOrFail( $id );
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $post->delete();
        return back()->with("success","Post Deleted Successfully");
    }




}
