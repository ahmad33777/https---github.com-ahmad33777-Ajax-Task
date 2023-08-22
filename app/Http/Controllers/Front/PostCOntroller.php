<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostCOntroller extends Controller
{
    //

    public function index()
    {

        $posts = Post::with('comments')->get();
        // dd($posts->toArray());
        return view('front.post', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => ['required', 'exists:posts,id'],
            'comment_content' => ['required', 'string']
        ]);

        $newComment = Comment::create([
            'post_id'=> $request->post('post_id'),
            'content'=>$request->post('comment_content')
        ]);
        return redirect()->back();






    }
}