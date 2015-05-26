<?php namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use Auth;
class CommentController extends Controller {

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
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id , Comment $comment)
    {
        $comment = $comment->whereId($id)->first();
        $comment->status = "b";
        $comment->save();
        return redirect()->back();
    }


}
