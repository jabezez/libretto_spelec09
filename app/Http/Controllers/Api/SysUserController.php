<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\SysUser;
use Carbon\Carbon;

class SysUserController extends Controller
{

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:sys_users',
            'password' => 'required|string|min:6',
        ]);

        $user = SysUser::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'user' => $user->only(['id', 'username']),
            'message' => 'Registration successful'
        ], 201);

        // return $this->createTokenWithExpiration($user);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        
        $user->tokens()->delete();
        
        return $this->createTokenWithExpiration($user);
    }

    private function createTokenWithExpiration($user): JsonResponse
    {
        $token = $user->createToken('api-token');
        
        $expiresAt = now()->addMinutes(config('sanctum.expiration'));
        
        $token->accessToken->expires_at = $expiresAt;
        $token->accessToken->save();
        
        return response()->json([
            'token' => $token->plainTextToken,
            'expires_at' => $expiresAt->toISOString(),
            'user' => $user->only(['id', 'username']),
            'message' => 'Registration successful - token created'
        ]);
    }

    private function isTokenExpired($token): bool
    {
        if (!$token->expires_at) {
            return false; 
        }
        
        return Carbon::now()->isAfter($token->expires_at);
    }
}