<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserInfo()
    {
        $user = auth()->user();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully received user information.',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 200);
    }
}
