<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class TokenController extends Controller
{
 
    public function create(Request $request): JsonResponse
    {
        $user = $request->user();
        

        $existingToken = $user->tokens()->first();
        
        if ($existingToken) {
            if ($this->isTokenExpired($existingToken)) {

                $existingToken->delete();
                return $this->createTokenWithExpiration($user);
            } else {
                return response()->json([
                    'message' => 'Token already exists and is valid',
                    'token' => $this->getTokenString($existingToken),
                    'token_exists' => true,
                    'expires_at' => $existingToken->expires_at?->toISOString(),
                    'created_at' => $existingToken->created_at->toISOString(),
                ]);
            }
        }
        
        return $this->createTokenWithExpiration($user);
    }
    

    public function regenerate(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->tokens()->delete();
        return $this->createTokenWithExpiration($user);
    }
    
    public function status(Request $request): JsonResponse
    {
        $user = $request->user();
        $token = $user->currentAccessToken();
        
        return response()->json([
            'has_token' => $token !== null,
            'token' => $token ? $this->getTokenString($token) : null,
            'is_expired' => $token ? $this->isTokenExpired($token) : null,
            'expires_at' => $token?->expires_at?->toISOString(),
            'created_at' => $token?->created_at->toISOString(),
            'time_remaining' => $token && $token->expires_at ? 
                Carbon::now()->diffInMinutes($token->expires_at, false) . ' minutes' : null,
        ]);
    }
    
    public function current(Request $request): JsonResponse
    {
        $user = $request->user();
        $token = $user->currentAccessToken();
        
        if (!$token) {
            return response()->json([
                'message' => 'No token found',
                'token' => null
            ], 404);
        }
        
        if ($this->isTokenExpired($token)) {
            $token->delete();
            return response()->json([
                'message' => 'Token was expired and has been deleted',
                'token' => null
            ], 401);
        }
        
        return response()->json([
            'message' => 'Current valid token',
            'token' => $this->getTokenString($token),
            'expires_at' => $token->expires_at?->toISOString(),
            'created_at' => $token->created_at->toISOString(),
        ]);
    }
    

    public function revoke(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->tokens()->delete();
        
        return response()->json([
            'message' => 'Token revoked successfully'
        ]);
    }
    
    private function createTokenWithExpiration($user): JsonResponse
    {

        $token = $user->createToken('api-token');
        
        $expiresAt = Carbon::now()->addMinutes(config('sanctum.expiration', 1440));
        
        $token->accessToken->update(['expires_at' => $expiresAt]);
        
        return response()->json([
            'token' => $token->plainTextToken,
            'expires_at' => $expiresAt->toISOString(),
            'created_at' => $token->accessToken->created_at->toISOString(),
            'message' => 'New token created successfully'
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