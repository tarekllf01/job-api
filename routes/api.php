<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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

Route::middleware(['auth:sanctum'])->group(function () {
    
    // post route
    Route::prefix('/post')->name('post.')->group(function (){
        Route::get('/list',[PostController::class,'index'])->name('list')->middleware('isGeneralUser');
        Route::get('/show/{id}',[PostController::class,'show'])->name('show')->middleware('isGeneralUser');
        Route::post('/create',[PostController::class,'store'])->name('create')->middleware('isAdminUser');
        Route::post('update/{id}',[PostController::class,'update'])->name('update')->middleware('isAdminUser');
        Route::delete('/delete/{id}',[PostController::class,'destroy'])->name('delete')->middleware('isAdminUser');
    });
    
    //  user route
    Route::prefix('/user')->name('user.')->group(function() {
        Route::post('/create-admin',[UserController::class,'store'])->name('createAdmin')->middleware('isAdminUser');
    });
});

// Auth routes  
Route::prefix('/auth')->name('auth.')->group(function(){
    Route::post('/register',[AuthController::class,'register'])->name('register');
    Route::post('/login',[AuthController::class,'login'])->name('login');
    Route::get('/logout',[AuthController::class,'logout'])->name('logout')->middleware(['auth:sanctum','isGeneralUser']);
});

// default un authorized redirect route
Route::get('/login', function ( ) {
    return response()->json(['message'=>'Un authorized','data'=>null],401);
})->name('login');




