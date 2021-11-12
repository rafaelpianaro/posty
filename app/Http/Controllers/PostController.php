<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::get();
        $posts = Post::paginate(25);
        return view('posts.index',['posts' => $posts]);
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
}
