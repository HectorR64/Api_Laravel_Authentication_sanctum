<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Models\User;


class AuthController extends Controller
{
    public function signup(Request $request){
        
        
        $user= User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password,

        ]);

        $token= $user->createToken('main')->plainTextToken;

        return response(compact('user', 'token'));

        
    }

    

    public function login(LoginRequest $request){

        $credencials= $request->validated();

        if(!Auth::attempt($credencials)){

            return response([
                'message'=>'Provided email or password incorrect'
            ]);
        }
       
        $user= Auth::user();
        $token= $user->createToken('main')->plainTextToken;

        return response(compact('user', 'token'));


    }




    public function logout(Request $request){
       
        $user= $request->user();

        $user->currentAccessToken()->delete();

        return response('', 204);

    }
}
