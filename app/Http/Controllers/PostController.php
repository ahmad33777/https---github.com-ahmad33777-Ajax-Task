<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
        return view('post.index', compact('posts'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string', 'min:1'],
        ]);

        Post::create($request->all());
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return response()->json([
            'status' => 200,
            'post' => $post
        ]);
    }
}