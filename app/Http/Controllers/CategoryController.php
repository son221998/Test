<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use App\Http\Controllers\UploadController;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $cloudController = new UploadController();
           
            $categories = Category::all();
            foreach($categories as $category){
                if(!empty($category['thumnail'])){
                    $category['thumnail'] = $cloudController->getSignedUrl($category['thumnail']);
                }
            }
            return response()->json([
                'message' => 'categories retrieved successfully',
                'categories' => $categories
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'categories retrieved failed',
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
            $cloudController = new UploadController();
            $category = new Category();
            $category->title= $request->title;
            $category->discription = $request->discription;
            $category->thumnail = $cloudController->UploadFile($request->file('thumnail'));
            $category->save();

            return response()->json([
                'message' => 'category created successfully',
                'category' => $category
            ], 201);
            
        }
        catch(\Exception $e){
                return response()->json([
                    'message' => 'category created failed',
                    'error' => $e->getMessage()
                ], 400);
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
       try{
        $cloudController = new UploadController();
        $category = Category::find($id);
        $category->title= !$request->title ? $category->title : $request->title;
        $category->discription = !$request->discription ? $category->discription : $request->discription;
        $category->thumnail = !$request->thumnail ? $category->thumnail : $cloudController->UploadFile($request->file('thumnail'));
        

        $category->save();

        return response()->json([
            'message' => 'category updated successfully',
            'category' => $category
        ], 201);
       }
         catch(\Exception $e){
          return response()->json([
                'message' => 'category updated failed',
                'error' => $e->getMessage()
          ], 400);
         }
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category,$id)
    {
        try{
            $category = Category::find($id);
            $cloudController = new UploadController();
            $cloudController->delete($category->thumnail);
            $category->delete();
            return response()->json([
                'message' => 'category deleted successfully',
                'category' => $category
            ], 201);
            
        }
        catch(\Exception $e){
                return response()->json([
                    'message' => 'category deleted failed',
                    'error' => $e->getMessage()
                ], 400);
            }
    }


   


   
}
