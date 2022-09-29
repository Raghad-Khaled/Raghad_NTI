<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $admin = Admin::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender'=> $request->gender,
            'phone' => $request->phone,
            'email'=> $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(
            [
                'token'=>'Bearer '.$admin->createToken($request->device_name)->plainTextToken
            ]
        );
    }

    public function login(LoginRequest $request)
    {
        $admin = Admin::where('email', $request->email)->first();
 
        if (! Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json(
            [
                'token'=>'Bearer '.$admin->createToken($request->device_name)->plainTextToken
            ]
        );
    }

    public function logout(Request $request)
    {

        // Revoke the token that was used to authenticate the current request...
        $request->user('sanctum')->currentAccessToken()->delete();
       

        return response()->json(
            [
                'message'=>'You are logged out from current device'
            ]
        );
    }

    public function logoutAll(Request $request)
    {

        // Revoke all tokens...
        $request->user('sanctum')->delete();
       

        return response()->json(
            [
                'message'=>'You are loghed out from all devices'
            ]
        );
    }

    public function account(Request $request)
    {

        return response()->json($request->user('sanctum')->toArray());
    }
}
