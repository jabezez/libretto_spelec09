<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{

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
        
        $existingToken = $user->tokens()->first();
        
        if ($existingToken && !$this->isTokenExpired($existingToken)) {
            return response()->json([
                'message' => 'Token is still valid',
                'token' => $this->getTokenString($existingToken),
                'token_exists' => true,
                'expires_at' => $existingToken->expires_at?->toISOString(),
                'user' => $user->only(['id', 'username'])
            ]);
        }
        
        $user->tokens()->delete();
        
        return $this->createTokenWithExpiration($user);
    }


    private function createTokenWithExpiration($user): JsonResponse
    {
        $token = $user->createToken('api-token');
        $token->accessToken->update([
            'expires_at' => now()->addMinutes(config('sanctum.expiration'))
        ]);
        
        return response()->json([
            'token' => $token->plainTextToken,
            'expires_at' => $expires_at->toISOString(),
            'user' => $user->only(['id', 'username']),
            'message' => 'Login successful - new token created'
        ]);
    }

    private function getTokenString($token): string
    {
        
        return $token->id . '|' . $token->token;
    }

    private function isTokenExpired($token): bool
    {
        if (!$token->expires_at) {
            return false; 
        }
        
        return Carbon::now()->isAfter($token->expires_at);
    }
}