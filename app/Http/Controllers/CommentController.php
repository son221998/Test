<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artical;
use App\Models\Comment;
use App\Models\ReplyComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //show all comment with post 

            $comments = Comment::with('artical')->get();
            return response()->json([
                'comments' => $comments
            ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'artical_id' => 'required',
        ]);
       //get own user id
       $comment = new Comment();
       $comment->content = $request->content;
       $comment->artical_id = $request->artical_id;
       $comment->author = auth()->user()->id;
       $comment->save();
       //user get 1 point 
        $user = User::find(auth()->user()->id);
        if($comment->author != $user->id)
        {
            $user->point = $user->point + 10;
            $user->save();
        }
        
        
       return response()->json([
           'message' => 'Comment created successfully',
           'comment' => $comment
       ],);
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
    public function show(Comment $comment)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment, $id)
    {
        try{
            //check user id == author
            //find comment id
            $comment = Comment::find($id);
            if($comment->author == auth()->user()->id)
            {
              
                $comment->content = $request->content;
                $comment->save();
                return response()->json([
                    'message' => 'Comment successfully updated',
                    'comment' => $comment
                ], 201);
            }
            else{
                return response()->json([
                    'message' => 'You are not author',
                ], 400);
            }
        }
            catch(\Exception $e){
                return response()->json([
                    'message' => 'Comment failed updated',
                    'error' => $e->getMessage()
                ], 400);
                
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Comment $comment, $id)
    {
        try{
            $comment = Comment::find($id);
            if($comment->author == auth()->user()->id){
            $comment->delete();
            $user = User::find(auth()->user()->id);
            $user->point = $user->point - 10;

            //delete all reply comment 
            $replyComments = ReplyComment::where('comment_id', $id)->get();
            foreach($replyComments as $replyComment)
            {
                $replyComment->delete();
            }
            $user->save();
            return response()->json([
                'message' => 'Comment successfully deleted',
                'comment' => $comment
            ], 201);
           }
              else{
                return response()->json([
                 'message' => 'You are not author',
                ], 400);
              }
            
        }
            catch(\Exception $e){
                return response()->json([
                    'message' => 'Comment failed deleted',
                    'error' => $e->getMessage()
                ], 400);
                
            }
    }

    public function showreply($id)
    {
        try{
            $comment = Comment::find($id);
            $replyComments = ReplyComment::where('comment_id', $id)->get();
          
            return response()->json([
                'message' => 'Comment and ReplyComment successfully retrieved',
                'comment' => $comment,
                'replyComments' => $replyComments
            ], 201);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Comment and ReplyComment failed retrieved',
                'error' => $e->getMessage()
            ], 400);
            
        }
    }

}

   
    
