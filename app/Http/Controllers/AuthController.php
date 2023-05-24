<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminPermision;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UploadController;




class AuthController extends Controller
{
    public function register(Request $request) 
    {

        //create new user 
        try{
            $cloudController = new UploadController();
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email; 
            $user->password = bcrypt($request->password);
            $user->avatar = $cloudController->UploadFile($request->file('avatar'));
            $user->save();
            return response()->json([
                'message' => 'User successfully registered',
                'user' => $user
            ], 201);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'User failed registered',
                'error' => $e->getMessage()
            ], 400);
        }
     
     
       
    }

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //no expired token
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    //add id from role to user
    
    public function index (){
      try{
        $cloudController = new UploadController();
        $user = User::all();
       //loop user 
        foreach($user as $user){
           if(!empty($user['avatar'])){
                $user['avatar'] = $cloudController->getSignedUrl($user['avatar']);
           }
        }
        return response()->json([
            'message' => 'User successfully get all',
            'user' => $user
        ], 201);
      }
        catch(\Exception $e){
            return response()->json([
                'message' => 'User failed get all',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    //delete function has middleware

   

   public function deleteOwnUser(Request $request)
   {
    try{
        $cloudController = new UploadController();
        $user = User::find(auth()->user()->id);
        $cloudController->deleteFile($user->avatar);
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

   public function updateOwnUser(Request $request)
   {
    try{
        $user = User::find(auth()->user()->id);
        $user->update($request->all());
        return response()->json([
            'message' => 'User successfully updated',
            'user' => $user
        ], 201);
        
    }
    catch(\Exception $e){
        return response()->json([
            'message' => 'User failed updated',
            'error' => $e->getMessage()
        ], 400);
    }
   }

   public function addRole(Request $request, $id){
    try {
        $user = User::find($id);
        $role = role::find($request->role_id);
        if($role){
            $user->role_id = $request->role_id;
            $user->save();
            return response()->json([
                'message' => 'User successfully added role',
                'user' => $user
            ], 201);
        }
        else{
            return response()->json([
                'message' => 'Role not found',
            ], 404);
        }
    
       }
       catch(\Exception $e){
        return response()->json([
            'message' => 'User failed added role',
            'error' => $e->getMessage()
        ], 400);
       }
}
public function logout() {
    auth()->logout();
    return response()->json(['message' => 'User successfully signed out']);
}
}
