<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index() 
    {
        try{
            // $cloudController = new UploadController();
            $countries = Country::all();
            // foreach($countries as $country){
            //     $country->flag = $cloudController->getSignedUrl($country->flag);
            // }
            return response()->json([
                'status' => 'success',
                'message' => 'Countries fetched successfully',
                'data' => $countries
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Countries fetched failed',
                'data' => $e->getMessage()
            ]);
        }

    }
}
