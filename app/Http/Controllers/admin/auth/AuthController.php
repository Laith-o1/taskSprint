<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response([
                'message' => 'Failed to authenticate',
            ], 401);
        }
        return response([
            'user' => auth()->guard('admin')->user(),
            'token' => auth()->guard('admin')->user()->createToken('admin_token')->plainTextToken,
            'token_type' => 'Bearer',
        ], 200);
    }
    public function logout() {

        Auth::user()->tokens()->delete();

        return response([
            'message' => 'User tokens deleted successfully',
        ], 200);
    }
}
