<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\ReplyComment;
use Illuminate\Http\Request;

class ReplyCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id)
    {
        try
        {
            $request->validate([
                'content' => 'required',
                'comment_id' => 'required',
            ]);
           //get own user id
           $comment = Comment::find($id);
           
           $replyComment = new ReplyComment();
           //comment id == comment
          $replyComment->comment_id = $id;
           $replyComment->content = $request->content;
           $replyComment->artical_id = $request->artical_id;
           $replyComment->author = auth()->user()->id;
           $replyComment->save();
              
           return response()->json([
               'message' => 'Comment created successfully',
                'comment' => $replyComment
           ],);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
         
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ReplyComment $replyComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReplyComment $replyComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request,$id)
    {
        try{
           
          //only own replycomment can edit
            $replyComment = ReplyComment::find($id);
            if($replyComment->author == auth()->user()->id)
            {
                $replyComment->content = $request->content;
                $replyComment->save();
                return response()->json([
                    'message' => 'ReplyComment successfully updated',
                    'replyComment' => $replyComment
                ], 201); 
            }
            else
            {
                return response()->json([
                    'message' => 'ReplyComment failed updated',
                    'error' => 'You are not the owner of this replyComment'
                ], 400);
            }
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'ReplyComment failed updated',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReplyComment $replyComment)
    {
        try{
            $replyComment -> delete();
            $user = User::find(auth()->user()->id);
            $user->point = $user->point - 10;
            return response()->json([
                'message' => 'ReplyComment successfully deleted',
                'replyComment' => $replyComment
            ], 201); 
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'ReplyComment failed deleted',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
