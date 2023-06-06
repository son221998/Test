<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\AdminPermision;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Redis;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;




class AuthController extends Controller
{
    public function register(Request $request)
    {

        //create new user
        try{
            // $cloudController = new UploadController();
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            // $user->telegram = $cloudController->UploadFile(($request->file('telegram')));
            $user->password = bcrypt($request->password);
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
    public function addAvatar(Request $request){
        try{
            $cloudController = new UploadController();
            $user = User::find($request->user()->id);
            $user->avatar = $cloudController->UploadFile($request->file('avatar'));
            $user->save();
            return response()->json([
                'message' => 'User successfully add avatar',
                'user' => $user

            ], 201);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'User failed add avatar',
                'error' => $e->getMessage()
            ], 400);
        }
    }
    public function login(Request $request){
        	// validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $model = User::query()->where('email', $request->email)->first();
        //show avatar as link
        if(!empty($model['avatar'])){
            $cloudController = new UploadController();
            $model['avatar'] = $cloudController->getSignedUrl($model['avatar']);
        }
        if(empty($model)){
            return request()->json([
                'status' => 500,
                'message' => 'Error',
            ]);
        }
        if(!Hash::check($request->password, $model->password)){
            return request()->json([
                'status' => 500,
                'message' => 'Password or Email incorrect',
            ]);
        }
        $token =$model->createToken(config('app.name'))->plainTextToken;
            return response()->json([
                'status' => 200,
                'message' => 'Sucess',
                'user' => $model,
                'token' => $token,
            ]);



     }

     public function refresh(Request $request){
        $request->user()->tokens()->delete();
        $token =$request->user()->createToken(config('app.name'))->plainTextToken;
        //if user has new token old token is expired

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'user' => $request->user(),
            'token' => $token,
        ]);
     }

        public function logout(Request $request){
            $request->user()->tokens()->delete();

            //delete token
            return response()->json([
                'status' => 200,
                'message' => 'Success',
            ]);
        }


    //add id from role to user

    public function index (){
      try{
        $cloudController = new UploadController();
         $user = User::all();
         
        foreach($user as $key => $value){
            $user[$key]['role_id'] = role::find($value['role_id'])->name;
            if(!empty($user['avatar'])){
                $user[$key]['avatar'] = $cloudController->getSignedUrl($value['avatar']);
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
        //if avatar is not emthy
        if(!empty($user['avatar'])){
            $cloudController->deleteFile($user['avatar']);
        }
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

        $cloudController = new UploadController();
        //can update own account
        $user = User::find(auth()->user()->id);
        $user->update($request->all());
        //if avatar is not emthy

        $user->save();
        return response()->json([
            'message' => 'User successfully edited',
            'user' => $user
        ], 201);


        //show avatar as link


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


public function userinfo()
{
    //show avatar as link
    $cloudController = new UploadController();
    $user = auth()->user();
    if(!empty($user['avatar'])){
        $user['avatar'] = $cloudController->getSignedUrl($user['avatar']);
    }
    $role = role::find($user['role_id']);
    $user['role_id'] = $role['name'];
    return response()->json([
        'message' => 'User successfully get info',
        'user' => $user
    ], 201);

}
public function redirectToProvider()
    {
        return Socialite::driver('google')->with(
            [
                'client_id' => '16333006419-ekp3fs5jvnfj5ojn7d97f52el2tv3e3u.apps.googleusercontent.com',
                'client_secret' => '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',
                'redirect_uri' => 'https://cinemagickh.com/api/auth/google/callback'
            ]
        )->redirect();



    }

}
