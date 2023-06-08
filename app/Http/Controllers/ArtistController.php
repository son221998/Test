<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Artist;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\UploadController;


class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       try{
        $cloudController = new UploadController();
        $artists = Artist::all();
        $country = Country::all();
        foreach($artists as $artist){
            $artist->profile = $cloudController->getSignedUrl($artist->profile);
            $artist->cover = $cloudController->getSignedUrl($artist->cover);
           foreach($country as $c){
            if($artist->country_code == $c->code){
                $artist->country_code = $c->name;
            }
           }
            
        }
            
            

            
        
        return response()->json([
            'status' => 'success',
            'message' => 'Artists fetched successfully',
            'data' => $artists
        ]);
       }
         catch(Exception $e){
          return response()->json([
                'status' => 'error',
                'message' => 'Artists fetched failed',
                'data' => $e->getMessage()
          ]);
         }
        
        
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try{
            $cloudController = new UploadController();
            $artist = new Artist();
            $country = Country::all();
           //check code in country 
              foreach($country as $c){
                if($request->country_code == $c->code){
                    $artist->first_name = $request->first_name;
                    $artist->last_name = $request->last_name;
                    $artist->gender = $request->gender;
                    $artist->dob = $request->dob;
                    $artist->dod = $request->dod;
                    $artist->profile =  $cloudController->UploadFile($request->file('profile'));
                    $artist->bio = $request->bio;
                    $artist->country_code = $request->country_code;
                    $artist->history = $request->history;
                    $artist->cover = $cloudController->UploadFile($request->file('cover'));
                    $artist->facebook = $request->facebook;
                    $artist->twitter = $request->twitter;
                    $artist->instagram = $request->instagram;
                    $artist->youtube = $request->youtube;
                    $artist->website = $request->website;
                    $artist->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Artist created successfully',
                'data' => $artist
                //co
            ]);
                   
                }
                else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Country code not found',
                    ], 404);
                }
              }

       
          
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Artist creation failed',
                'data' => $e->getMessage()
            ]);
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
    public function show(Artist $artist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artist $artist,$id)
    {
        try{
            $artist = Artist::find($id);
            $artist->update($request->all());
            if($request->country_code != null ){
                $country = Country::all();
                foreach($country as $c){
                    if($request->country_code == $c->code){
                        $artist->country_code = $request->country_code;
                    }
                    else{
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Country code not found',
                        ], 404);
                    }
                }
                 
            }
            $artist->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Artist updated successfully',
                'data' => $artist
                //co
            ]); 
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Artist updation failed',
                'data' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        //
    }
}
