<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use  Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Auth;
use App\Rules\contentRule;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['password.confirm'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('comments', 'user.profile', 'tags')->withCount('tags')->latest()->get();
        return view("Posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Posts.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = $this->validator($request);
        $v->validate();
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            if ($file->isValid()) {
                $data['image'] = $file->store("image", "public");
            }
        }
        //Auth::id();
        $data['user_id'] = Auth::user()->id;
        $post =  Post::create($data); //mass assigment

        $this->saveTag($post, $request);
        return redirect("/posts")->with("flashMessage", 'post is stored');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post =  Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $v = $this->validator($request);
        $v->validate();
        $post = Post::findOrFail($id);
        $post->update($request->all()); //mass assigment
        $this->saveTag($post, $request);
        return redirect("/posts")->with("flashMessage", 'post is updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect("/posts")->with("flashMessage", 'post is deleted');
    }
    public function trash()
    {
        return view("Posts.index", [
            "posts" => Post::onlyTrashed()->get()
        ]);
    }
    public function restore(Request $request, $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();
        return redirect("/posts")->with("flashMessage", 'post is restored');
    }
    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->forceDelete();
        return redirect("/posts")->with("flashMessage", 'post is deleted Permanently');
    }

    protected function validator($request)
    {
        return Validator::make($request->all(), [
            "content" => ["required", "content:nox,c+", new contentRule(["456", "1235415", '51512'])]
        ]);
    }
    public function saveTag($post, $request)
    {
        $tag_ids = [];
        preg_match_all('/\#([^\s]+)/', $request->post('content'), $matches);
        //dd($matches);
        if ($matches) {
            $tags = $matches[1];
            foreach ($tags as $tag_name) {
                $tag = Tag::where('name', '=', $tag_name)->first();
                if (!$tag) {
                    $tag = Tag::create([
                        'name' => $tag_name
                    ]);
                }/*
                $tag = Tag::firstOrCreate([
                    'name' => $tag_name
                ], []);*/
                $tag_ids[] = $tag->id;
            }
            $post->tags()->sync($tag_ids);
            //sync  , attach,detach,syncwihtoutDetach
        }
    }
}
