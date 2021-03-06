<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class PostCommentsController extends Controller
{

    public function checkrequest(Request $request)
    {
        if($request->input('update')) { $this->update($request, $request->id);}
        elseif($request->input('delete')) { $this->delete($request);}

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::paginate(5);

        return view('admin.comments.index', compact('comments'));
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

        request()->validate(['body' => 'required|min:2|max:255']);

        Comment::create(
            [
                'post_id'=> $request->post_id,
                'body'   => $request->body,
                'author' => $user->name,
                'email'  => $user->email,
                'photo'  => $user->photo_path,
            ]);

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

        return view('admin.comments.show', compact('comments'));
    }
    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        Comment::findorfail($id)->update(['is_active'=> 1]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $comments = Comment::FindorFail($request->checkBoxArray);

        if (empty($request->checkBoxArray))
        {
            return redirect()->back();
        }
        else
        {
            foreach ($comments as $comment)

            $comment->delete();

            return redirect()->back();

        }

        return redirect()->back();
    }
}
