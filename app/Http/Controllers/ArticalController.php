<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use App\Models\Artical;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\UploadController;
use App\Models\feature;
use App\Models\Type;

class ArticalController extends Controller
{
    public function create(Request $request)
    {
        try{
            $cloudController = new UploadController();
            //find category has or not
            $category = Category::find($request->category_id);
            if(!$category){
                return response()->json([
                    'message' => 'category not found',
                ], 404);
            }

            //check tags has or not
            $tags = Tags::find($request->tag_id);
            if(!$tags){
                return response()->json([
                    'message' => 'tags not found',
                ], 404);
            }

            $type = Type::find($request->type_id);
            if(!$type){
                return response()->json([
                    'message' => 'type not found',
                ], 404);
            }

            $feature = feature::find($request->feature_id);
            if(!$feature){
                return response()->json([
                    'message' => 'feature not found',
                ], 404);
            }

            

            $artical = new Artical();
            $artical->title = $request->title;
            $artical->content = $request->content;
            $artical->author = $request->author;
            $artical->category_id = $request->category_id;
            $artical->tag_id = $request->tag_id;
            $artical->type_id = $request->type_id;
            $artical->origin = $request->origin;
            $artical->feature_id = $request->feature_id;
            $artical->thumnail = $cloudController->UploadFile($request->file('thumnail'));
            $artical->save();

            

            return response()->json([
                'message' => 'artical created successfully',
                'artical' => $artical
            ], 201);
            
        }
        catch(\Exception $e){
                return response()->json([
                    'message' => 'artical created failed',
                    'error' => $e->getMessage()
                ], 400);
            }
        
    }

    public function index()
    {
        try{
            $cloudController = new UploadController();
            
            $articals = Artical::all();
            foreach($articals as $artical){
                $feature = feature::find($artical->feature_id);
                $tags = Tags::find($artical->tag_id);
                $artical['category_id'] = $artical->category->title;
                $artical['tag_id'] = $tags->title;
                $artical['type_id'] = $artical->type->name;
                $artical['feature_id'] = $feature->title;
                if($artical['like'] == null){
                    $artical['like'] = 0;
                }

               //show tag 
                if(!empty($artical['thumnail'])){
                    $artical['thumnail'] = $cloudController->getSignedUrl($artical['thumnail']);
                }
            }
            return response()->json([
                'message' => 'articals retrieved successfully',
                'articals' => $articals
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'articals retrieved failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }
    public function edit(Request $request, $id)
    {
        //update artical all field can be null
        try{
            $cloudController = new UploadController();
            $category = Category::find($request->category_id);
            if(!$category){
                return response()->json([
                    'message' => 'category not found',
                ], 404);
            }

            //check tags has or not
            $tags = Tags::find($request->tag_id);
            if(!$tags){
                return response()->json([
                    'message' => 'tags not found',
                ], 404);
            }
            $type = Type::find($request->type_id);
            if(!$type){
                return response()->json([
                    'message' => 'type not found',
                ], 404);
            }

            $feature = feature::find($request->feature_id);
            if(!$feature){
                return response()->json([
                    'message' => 'feature not found',
                ], 404);
            }
            $artical = Artical::find($id);
            $artical->update($request->all());
            if($request->hasFile('thumnail')){
                $cloudController->deleteFile($artical['thumnail']);
                $artical->thumnail = $cloudController->UploadFile($request->file('thumnail'));
            }
            $artical->save();

            return response()->json([
                'message' => 'artical updated successfully',
                'artical' => $artical
            ], 201);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'artical updated failed',
                'error' => $e->getMessage()
            ], 400);
        }

    }

    public function delete(Request $request, $id)
    {
        try{

            $artical = Artical::find($id);
            //get thumnail id

            $cloudController = new UploadController();
            $cloudController->delete($artical->thumnail);
            
            $artical->delete();
            return response()->json([
                'message' => 'artical deleted successfully',
                'artical' => $artical
            ], 201);

        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'artical deleted failed',
                'error' => $e->getMessage()
            ], 400);
           
        }

    }

    public function show($id)
    {
        try{
            $artical = Artical::find($id);
            return response()->json([
                'message' => 'artical show successfully',
                'artical' => $artical
            ], 201);

        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'artical show failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }
    public function showArticalHasComment($id)
    {
        //show artical has comment if comment has reply comment also show

        try{
            $artical = Artical::find($id);
            $artical->comments;
        
        

            return response()->json([
                'message' => 'artical show successfully',
                'artical' => $artical
            ], 201);

        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'artical show failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    //short artical by category_id
    public function shortArticalByCategory($id)
    {
        try{
            $articals = Artical::where('category_id', $id)->get();
            return response()->json([
                'message' => 'artical short successfully',
                'articals' => $articals
            ], 201);

        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'artical short failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
