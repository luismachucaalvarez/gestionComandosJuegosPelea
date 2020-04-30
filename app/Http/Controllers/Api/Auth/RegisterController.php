<?php

namespace App\Http\Controllers\Api\Auth;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255|confirmed',
            'password_confirmation' => 'required|string|min:8|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>'error',
                'messages'=>$validator->messages()
            ],200);
        }

        $user = new User;
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        $user->roles()->attach(Role::where('name', 'user')->first());

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }
}
