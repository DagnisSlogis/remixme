<?php namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use Auth;
class CommentController extends Controller {

    /**
     * Pieejas liegšana viesiem
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Pievieno komentāru
     *
     * @param $id
     * @param AddCommentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add($id , AddCommentRequest $request)
    {
        $comment =  new Comment;
        $comment->text = $request['text'];
        $comment->user_id = Auth::user()->id;
        $comment->comp_id = $id;
        $comment->save();
        \Session::flash('new_comment', $comment->id);
        return redirect()->back();
    }

    /**
     * Dzēšs komentāru
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $comment = Comment::whereId($id)->first();
        if($comment->user_id == Auth::user()->id OR Auth::user()->isAdmin())
        {
            $comment->status = "b";
            $comment->save();
        }
        return redirect()->back();
    }


}
