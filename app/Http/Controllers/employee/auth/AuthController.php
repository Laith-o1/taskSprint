<?php

namespace App\Http\Controllers\employee\auth;

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

        if (!Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response([
                'message' => 'Failed to authenticate',
            ], 401);
        }
        return response([
            'user' => auth()->guard('employee')->user(),
            'token' => auth()->guard('employee')->user()->createToken('employee_token')->plainTextToken,
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
