<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminDeleteUser(Request $request, $id)
   {
    try{
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'message' => 'User successfully deleted',
            'user' => $user
        ], 201);
        
    }
     catch(\Exception $e){
        return response()->json([
            'message' => 'User failed deleted',
            'error' => $e->getMessage()
        ], 400);
        
     }
   }
  

}
