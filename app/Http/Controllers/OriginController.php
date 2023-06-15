<?php

namespace App\Http\Controllers;

use App\Models\Origin;
use Illuminate\Http\Request;
use App\Http\Controllers\UploadController;

use function PHPUnit\Framework\isEmpty;

class OriginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $cloudController = new UploadController();
            $origin = Origin::all();
            foreach ($origin as $origins){
                //show logo as link
                $origins->logo = $cloudController->getSignedUrl($origins->logo);
            }
            return response()->json([
                'message' => 'OK',
                'origin' => $origin
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
            $cloudController = new UploadController();
            $origin = new Origin();
            $origin->name = $request->name;
            $origin->description = $request->description;
            $origin->link_fb = $request->link_fb;
            $origin->logo = $cloudController->UploadFile($request->file('logo'));
            $origin->save();
            return response()->json([
                'message' => 'OK',
                'origin' => $origin
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
    public function show(Origin $origin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Origin $origin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            $cloudController = new UploadController();
            $origin = Origin::find($id);
            $origin->update($request->all());
            if(!empty($request->file('logo'))){
                $origin->logo = $cloudController->UploadFile($request->file('logo'));
            }
            $origin->save();
            return response()->json([
                'message' => 'OK',
                'origin' => $origin
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $origin = Origin::find($id);
            $origin->delete();
            return response()->json([
                'message' => 'OK',
                'origin' => $origin
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
