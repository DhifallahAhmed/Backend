<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTExceptions;
use App\Models\HeureSup;

class UserController extends Controller
{
   public function getUser(){
        return response()->json(User::all(),200);
   }

   public function getUserById ($id){
        $user = User::find($id);
        if(is_null($user)){
            return response()->json(['message' => 'User Not Found'], 404);
        }
        return response()->json($user::find($id), 200);
   }

   public function updateUser(Request $request, $id){
    $user = User::find($id);
    if(is_null($user)){
        return response() -> json(['message' => 'User Not Found'],404);
    }
    $user->update($request->has('password') ? array_merge($request->except('password'), ['password' => bcrypt($request->input('password'))]) : $request->except('password'));}

    public function deleteUser(Request $request, $id){
    $user = User::find($id);
    if(is_null($user)){
        return response() -> json(['message' => 'user Not Found'],404);
    }
    $user->delete();
    return response()->json(null,204);

}
    
    
    public function register(Request $request){
        $user = User::where('email', $request['email'])->first();
        
        if($user){
            $response['status'] = 0;
            $response['message'] = 'Email Already Exists';
            $response['code']=409;
        }
        else{
        $user = User::create ([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);
        $response['status'] = 1;
        $response['message'] = 'User Registered Successfully';
        $response['code']=200;
        }
        return response()->json($response);
    }
    
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        try{
            if(!JWTAuth::attempt($credentials)){
                $response['data'] = null;
                $response['status'] = 0;
                $response['code'] = 401;
                $response['message'] = 'Email or Password is incorrect';
                return response()->json($response);
            }

        } catch(JWTException $e){
            $response['data'] = null;
            $response['code'] = 500;
            $response['message'] = 'Could Not Create Token';
            return response()->json($response);
        }
        $user = auth()->user();
        $data['token'] = auth()->claims(
            [
               'user' => $user
            ]
        )->attempt($credentials);
            $response['data'] = $data;
            $response['status'] = 1;
            $response['code'] = 200;
            $response['isAdmin']=$user->isAdmin;
            $response['message'] = 'Login Successfully';
            return response()->json($response);
    }
}
