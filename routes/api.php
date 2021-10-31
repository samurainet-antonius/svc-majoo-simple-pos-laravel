<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\KategoriController;
use App\Http\Controllers\v1\ProdukController;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\ReportController;

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


Route::group(['prefix' => 'v1', 'middleware' => 'cors'],function(){

    Route::group(['prefix' => 'auth'],function(){

        Route::post('/login',[AuthController::class,'login']);

        Route::get('/token',[AuthController::class,'getAuthenticatedUser'])->middleware('jwt.verify');
        Route::get('/logout',[AuthController::class,'logout'])->middleware('jwt.verify');
        
    });

    Route::group(['prefix' => 'kategori'],function(){

        Route::get('/',[KategoriController::class,'show']);
        Route::get('/search',[KategoriController::class,'search']);
        Route::get('/{uuid}',[KategoriController::class,'detail']);
        Route::post('/add',[KategoriController::class,'add'])->middleware('jwt.verify');
        Route::put('/edit/{uuid}',[KategoriController::class,'edit'])->middleware('jwt.verify');
        Route::delete('/delete/{uuid}',[KategoriController::class,'delete'])->middleware('jwt.verify');
        
    });

    Route::group(['prefix' => 'produk'],function(){

        Route::get('/',[ProdukController::class,'show']);
        Route::get('/{uuid}',[ProdukController::class,'detail']);
        Route::post('/add',[ProdukController::class,'add'])->middleware('jwt.verify');
        Route::put('/edit/{uuid}',[ProdukController::class,'edit'])->middleware('jwt.verify');
        Route::delete('/delete/{uuid}',[ProdukController::class,'delete'])->middleware('jwt.verify');
        
    });

    Route::group(['prefix' => 'report'],function(){

        Route::get('/',[ReportController::class,'show'])->middleware('jwt.verify');
        
    });
    
});