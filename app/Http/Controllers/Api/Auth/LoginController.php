<?php

namespace App\Http\Controllers\Api\Auth;

use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()
            ],200);
        }

        if (!$token = Auth::guard('api')->attempt(['email'=>$request->email, 'password'=>$request->password])){
            return response()->json(['error'=>'Unauthorizedo'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'message' => 'Token entregado',
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function user(){
        return response()->json(Auth::guard('api')->user());
    }

    public function refresh(){
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    public function logout(){
        Auth::guard('api')->logout();

        return response()->json([
            'status'=>'success',
            'message'=>'Sesión ya cerrada con éxito'
        ], 200);
    }
}
