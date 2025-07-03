<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\SysUserController;


Route::post('/login', [SysUserController::class, 'login']);

Route::post('/register', [SysUserController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('books', BookController::class);
    Route::apiResource('genres', GenreController::class);
    Route::apiResource('books.reviews', ReviewController::class);

});