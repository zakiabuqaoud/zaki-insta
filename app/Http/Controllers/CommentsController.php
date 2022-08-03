<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'content' => 'required|string|max:1000',
            'post_id' => 'required|exists:posts,id',
        ]);
        //1
        $user = $request->user();
        $comment = $user->comments()->create([
            "content" => $request->post("content"),
            "post_id" => $request->post("post_id")
        ]);
        $post = $comment->post->increment('comments_number');

        //2
        /*
        $post = Post::findOrFail($request->post("post_id"));
        $post->comments()->create([
            "user_id" => Auth::id(),
            "content" => $request->post("content")
        ]);
        //3
        $comment = Comment::create([
            "user_id" => Auth::id(),
            "content" => $request->post("content"),
            "post_id" => $request->post("post_id")
        ]);*/

        return redirect()->back()->with("flashMessage", "comment added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
