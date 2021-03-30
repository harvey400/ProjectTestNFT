<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class PostController extends Controller
{
    /**
    *
    * Function Name: postComment
    * Function Name: insert to Database
    * 
    * @param object $request
    * @return String success
    *
    */
    public function postComment(Request $request){
        
        try{
            $comment = new Comment();
            $comment->comment_id = $request->comment_id;
            $comment->user_id   = $request->user_id;
            $comment->level     = $request->level;
            $comment->name      = $request->name;
            $comment->body      = $request->body;
            $comment->save();
            return "success";

        }catch(Throwable $e){
            return $e->getMesasage();
        }
    }
    
    /** 
    *
    * Function Name: getComment
    * Function Name: acquire data from  Database
    * 
    * @param object $request
    * @return object $comments
    *
    */
    public function getComment(Request $request){
        try{

            $comments = Comment::where('comment_id',0)
                                ->with('replies.replies2')
                                ->orderByDesc('created_at')->get();
            return $comments;
        
        }catch(Throwable $e){
            return $e->getMesasage();
        }
    }
}
