<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class PostCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();

        return view('admin.comments.index', compact('comments'));
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
        $user = Auth::user();

        $input =
            [
                'post_id'=> $request->post_id,
                'body'   => $request->body,
                'author' => $user->name,
                'email'  => $user->email,
                'photo'  => $user->photo_path,
            ];

        Comment::create($input);

        Session()->flash('comment_message','Your comment has been submitted and is waiting moderator review');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::FindorFail($id);

        $comments = $post->comments;

        return view('admin.comments.show', compact('comments'));    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        Comment::FindorFail($id)->update(['is_active'=> 1]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::findorfail($id)->delete();

        return redirect()->back();
    }
}
