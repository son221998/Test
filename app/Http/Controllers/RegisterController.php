<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;

class RegisterController extends Controller
{
    public function store(Request $resquest){
        $input = $request->all();
        User::create([
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'email' => $input['email'],
            'password' => Hash::make($input['password'])
        ]);
            return response()->json(['status'=> true,
                                     'message'=> "Register Success"
            ]);
    }
}
