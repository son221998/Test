<?php

namespace App\Http\Controllers;

use App\Models\like;
use App\Models\User;

use App\Models\Artical;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class LikeController extends Controller
{
    public function index()
    {
        //show all like with post 
        $likes = like::with('artical')->get();
        return response()->json([
            'likes' => $likes
        ]);
    }
    public function create(Request $request)
    {
        
        try{
           
            $like = new like();
            //user can like 1 time
            $check = like::where('user_id',auth()->user()->id)->where('artical_id',$request->artical_id)->first();
            if($check != null){
                return response()->json([
                    'message' => 'you liked this post'
                ], 400);
            }
            $like->user_id = auth()->user()->id;
            $like->artical_id = $request->artical_id;
            $like->save();
            //add user 1 point
            $user = User::find(auth()->user()->id);
            if($like->user_id != $user->id)
            {
                $user->point = $user->point + 1;
                $user->save();
            }
            $artical = Artical::find($request->artical_id);
            $artical->like = $artical->like + 1;
            $artical->save();
            
            
            $user->save();
            return response()->json([
                'message' => 'like created successfully',
                'like' => $like
            ], 201);

        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'like created failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }
   
    public function unlike($id,)
    {
        try{
            $user = User::find(auth()->user()->id);
           $like = like::find($id);
          
           //only like user can unlick
              if($user->id != $like->user_id){
                return response()->json([
                 'message' => 'you are not like this post',
                ], 400);
              }
              $like->delete();
              //delete user 1 point
                $user = User::find(auth()->user()->id);
                if($like->user_id != $user->id)
                {
                    $user->point = $user->point - 1;
                    $user->save();
                }
                $artical = Artical::find($like->artical_id);
                $artical->like = $artical->like - 1;
                $artical->save();

              return response()->json([
                  'message' => 'like deleted successfully',
              ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'like deleted failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
