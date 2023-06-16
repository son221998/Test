<?php

namespace App\Http\Controllers;

use App\Models\Artical;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $subCategory = SubCategory::all();
            return response()->json([
                'message' => 'OK',
                'subCategory' => $subCategory
            ], 200);  
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'failed',
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
            $subCategory = new SubCategory();
            $subCategory->name = $request->name;
            $subCategory->description = $request->description;
            $subCategory->save();
            return response()->json([
                'message' => 'OK',
                'subCategory' => $subCategory
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'failed',
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
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }

    public function showartical($id){
        try{
              $subCategory = SubCategory::find($id);
            $artical = Artical::where('sub_cateogry_id', $id)->get();
            return response()->json([
                'message' => 'OK',
                'artical' => $artical,
                'subCategory' => $subCategory
            ], 200);

              

        
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
