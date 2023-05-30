<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $types = Type::all();
            return response()->json([
                'message' => 'Successfully retrieved types',
                'types' => $types
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Failed retrieved types',
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
            $type = new Type();
            $type->name = $request->name;
            $type->description = $request->description;
            $type->save();
            return response()->json([
                'message' => 'Type successfully created',
                'type' => $type
            ], 201);

        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Type failed created',
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
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type, Request $request)
    {
        try{
            $type->name = $request->name;
            $type->description = $request->description;
            $type->save();
            return response()->json([
                'message' => 'Type successfully created',
                'type' => $type
            ], 201);

        }
        
        catch(\Exception $e){
            return response()->json([
                'message' => 'Type failed created',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type,$id)
    {
        try{
            $type = Type::find($id);
            $type->delete();
            return response()->json([
                'message' => 'Type successfully deleted',
                'type' => $type
            ], 201);

        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Type failed deleted',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
