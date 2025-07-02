<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TokenController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/test-auth', function (Request $request) {
    return response()->json([
        'authenticated' => true,
        'user' => $request->user(),
        'message' => 'Auth working!'
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());

    Route::get('/tokens/status', [TokenController::class, 'status']);
    Route::get('/tokens/current', [TokenController::class, 'current']);
    Route::post('/tokens/create', [TokenController::class, 'create']);
    Route::post('/tokens/regenerate', [TokenController::class, 'regenerate']);
    Route::delete('/tokens/revoke', [TokenController::class, 'revoke']);
});