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
            'username' => 'required|unique:sys_users',
            'password' => 'required|min:6',
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
        
        $this->deleteExpiredTokens($user);
        if ($this->hasValidToken($user)) {
            return response()->json([
                'message' => 'Login successful - valid token already exists',
                'user' => $user->only(['id', 'username']),
                'token_status' => 'existing_valid'
            ]);
        }
        
        return $this->createTokenWithExpiration($user);
    }
    
    private function hasValidToken($user): bool
    {
        $tokens = $user->tokens()->get();
        
        foreach ($tokens as $token) {
            if (!$this->isTokenExpired($token)) {
                return true;
            }
        }
        
        return false;
    }
    
    private function deleteExpiredTokens($user): void
    {
        $tokens = $user->tokens()->get();
        
        foreach ($tokens as $token) {
            if ($this->isTokenExpired($token)) {
                $token->delete();
            }
        }
    }
    
    private function createTokenWithExpiration($user): JsonResponse
    {
        $token = $user->createToken('api-token');
        
        $expiresAt = now()->addMinutes(config('sanctum.expiration'));
        
        $token->accessToken->expires_at = $expiresAt;
        $token->accessToken->save();
        
        return response()->json([
            'message' => "Login successful. New token created. Copy token because you won't be able to get this again",
            'token' => $token->plainTextToken,
            'expires_at' => $expiresAt->toISOString(),
            'user' => $user->only(['id', 'username']),
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