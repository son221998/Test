<?php

namespace App\Http\Controllers;

use App\Models\Appversion;
use Illuminate\Http\Request;

class AppversionController extends Controller
{
    // public function create(Request $request)
    // {
    //     try {
    //         $appversion = new Appversion();
    //         $appversion->version = $request->version;
    //         $appversion->description = $request->description;
    //         $appversion->platform = $request->link_ios;
    //         $appversion->status = $request->status;
    //         $appversion->save();
    //         return response()->json([
    //             'message' => 'Appversion successfully created',
    //             'appversion' => $appversion
    //         ], 201);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Appversion failed created',
    //             'error' => $e->getMessage()
    //         ], 400);
    //     }
    // }

    public function index()
    {
        try{
            $appversion = Appversion::all();
            return response()->json([
                'message' => 'Appversion successfully get',
                'appversion' => $appversion
                
            ], 201);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Appversion failed get',
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
    public function show(Appversion $appversion)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        try{
            $appversion = Appversion::find($id);
            $appversion->update($request->all());
            $appversion->save();
            return response()->json([
                'message' => 'Appversion successfully get',
                'appversion' => $appversion
                
            ], 201);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Appversion failed get',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appversion $appversion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appversion $appversion, $id)
    {
        try{
            $appversion = Appversion::find($id);
            $appversion->delete();
            return response()->json([
                'message' => 'Appversion successfully deleted',
                'appversion' => $appversion
                
            ], 201);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Appversion failed deleted',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function GetfirstApp () 
    {
        try{
           //show only first 
            $appversion = Appversion::first();
            return response()->json([
                'message' => 'Appversion successfully get',
                'appversion' => $appversion
                
            ], 201);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Appversion failed get',
                'error' => $e->getMessage()
            ], 400);
        }
    }

   
    
}
