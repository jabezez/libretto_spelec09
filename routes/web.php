<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\SysUserController;



Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/', function () {
        return view('dashboard');
    });

    Route::get('logout', [SysUserController::class, 'logout'])->name('logout');
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);
    Route::resource('genres', GenreController::class);
    Route::resource('books.reviews', ReviewController::class);

});


 
Route::get('login',[SysUserController::class,'login'])->name('login');
Route::post('login',[SysUserController::class,'authenticate'])->name('authenticate');
Route::get('register',[SysUserController::class,'register'])->name('register');
Route::post('register',[SysUserController::class,'store'])->name('store');
