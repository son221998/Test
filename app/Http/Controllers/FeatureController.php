<?php

namespace App\Http\Controllers;

use App\Models\feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        try{
            $features = feature::all();
            return response()->json([
                'message' => 'features retrieved successfully',
                'features' => $features
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'features retrieved failed',
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
            $feature = new feature();
            $feature->title = $request->title;
            $feature->discription = $request->discription;
            $feature->save();

            return response()->json([
                'message' => 'feature created successfully',
                'feature' => $feature
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'feature created failed',
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
    public function show(feature $feature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
       try{
            $feature = feature::find($id);
            $feature->update($request->all());
            $feature->save();

            return response()->json([
                'message' => 'feature updated successfully',
                'feature' => $feature
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'feature updated failed',
                'error' => $e->getMessage()
            ], 400);
       }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, feature $feature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try{
            $feature = feature::find($id);
            $feature->delete();

            return response()->json([
                'message' => 'feature deleted successfully',
                'feature' => $feature
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'feature deleted failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
