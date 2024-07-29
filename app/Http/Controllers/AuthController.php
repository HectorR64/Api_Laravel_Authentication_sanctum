<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;


class AuthController extends Controller
{
    public function register(Request $request){
        
        
        $user= User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password,

        ]);

       return response(new UserResource($user) , 201);
        
    }

    

    public function login(LoginRequest $request)
    {
        $credenciales = $request->validated();
    
        if (!Auth::attempt($credenciales)) 
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
    
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 400);
    }
    




    public function logout(Request $request){
       
        $user= $request->user();

        $user->currentAccessToken()->delete();

        return response('', 204);

    }
}
