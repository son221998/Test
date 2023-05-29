<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
           
            $tags = Tags::all();
            return response()->json([
                'message' => 'tags retrieved successfully',
                'tags' => $tags
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'tags retrieved failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try{
            $tags = new Tags();
            $tags->title= $request->title;
            $tags->description = $request->description;
            $tags->save();

            return response()->json([
                'message' => 'tags created successfully',
                'tags' => $tags
            ], 201);
            
        }
        catch(\Exception $e){
                return response()->json([
                    'message' => 'tags created failed',
                    'error' => $e->getMessage()
                ], 400);
            }
    }

   
    public function update(Request $request, Tags $tags)
    {
        try{
            $tags->update($request->all());
            $tags->save();

            return response()->json([
                'message' => 'tags updated successfully',
                'tags' => $tags
            ], 201);
            
        }
        catch(\Exception $e){
                return response()->json([
                    'message' => 'tags updated failed',
                    'error' => $e->getMessage()
                ], 400);
            }
        }
 
    public function destroy(Tags $tags,$id)
    {
        try{
            $tags = Tags::find($id);
            $tags->delete();

            return response()->json([
                'message' => 'tags deleted successfully',
                'tags' => $tags
            ], 201);
            
        }
        catch(\Exception $e){
                return response()->json([
                    'message' => 'tags deleted failed',
                    'error' => $e->getMessage()
                ], 400);
            }
    }
}
