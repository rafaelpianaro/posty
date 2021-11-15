<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::get();
        // $posts = Post::orderBy('created_at','desc')->with(['user','likes'])->paginate(15);
        $posts = Post::latest()->with(['user','likes'])->paginate(15);
        return view('posts.index',['posts' => $posts]);
    }

    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $request->user()->posts()->create($request->only('body'));
        return back();

        // possible make like this
        // $request->user()->posts()->create([
        //     // 'user_id' => laravel do it automaticaly
        //     'body' => $request->body
        // ]);

        // possible make like this
        // Post::create([
        //     'user_id' => auth()->user()->id,
        //     'body' => $request->body
        // ]);
    }

    public function destroy(Post $post)
    {
        // dd($post);
        // if (!$post->ownedBy(auth()->user()))
        //     dd('no');
        $this->authorize('delete', $post); // throw exeption
        $post->delete();
        return back();
    }
}
