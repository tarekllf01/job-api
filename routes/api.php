<?php

use App\Http\Controllers\API\AuthController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/post')->name('post.')->group(function (){
    Route::get('/list',[Post::class,'index'])->name('list');
    Route::get('/show/{id}',[Post::class,'show'])->name('show');
    Route::post('/create',[Post::class,'store'])->name('create');
    Route::put('update/{id}',[Post::class,'update'])->name('update');
    Route::delete('/delete/{id}',[Post::class,'destroy'])->name('delete');
});


Route::prefix('/user')->name('user.')->group(function(){
    Route::post('/create-admin',[User::class,'store'])->name('createAdmin');
});

Route::prefix('/auth')->name('auth.')->group(function(){
    Route::post('/register',[AuthController::class,'register'])->name('register');
    Route::post('/login',[AuthController::class,'login'])->name('login');
    Route::get('/logout',[AuthController::class,'logout'])->name('register');
});
