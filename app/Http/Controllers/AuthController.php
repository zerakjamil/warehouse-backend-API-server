<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'sometimes|string',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'invalid credentials'
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ]);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('basic-token',['none'])->plainTextToken;
            $success['role'] = 'Basic Branch';

            if ($user->isSuperAdmin()) {
                $success['token'] = $user->createToken('super-admin-token', ['create', 'update', 'destroy'])->plainTextToken;
                $success['role'] = 'Super Admin';
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully',
                'token' => $success['token'],
                'role' =>  $success['role'],
            ]);
        }
            return response()->json([
                'status' => 'error',
                'message' => 'invalid credentials'
            ]);
    }
}
