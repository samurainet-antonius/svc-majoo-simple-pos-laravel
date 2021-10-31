<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin'],function(){

    Route::get('/home', function () {
        return view('admin.home');
    })->name('home');

    Route::group(['prefix' => 'kategori'],function(){

        Route::get('/', function () {
            return view('admin.kategori.show');
        })->name('kategori');

        Route::get('/add', function () {
            return view('admin.kategori.add');
        })->name('add-kategori');

        Route::get('/edit/{uuid}', function () {
            return view('admin.kategori.edit');
        })->name('edit-kategori');

    });

    Route::group(['prefix' => 'produk'],function(){

        Route::get('/', function () {
            return view('admin.produk.show');
        })->name('produk');

        Route::get('/add', function () {
            return view('admin.produk.add');
        })->name('add-produk');

        Route::get('/edit/{uuid}', function () {
            return view('admin.produk.edit');
        })->name('edit-produk');

    });

    Route::group(['prefix' => 'pelanggan'],function(){

        Route::get('/', function () {
            return view('admin.pelanggan.show');
        })->name('pelanggan');

        Route::get('/add', function () {
            return view('admin.pelanggan.add');
        })->name('add-pelanggan');

    });

    Route::group(['prefix' => 'user'],function(){

        Route::get('/', function () {
            return view('admin.user.show');
        })->name('user');

        Route::get('/add', function () {
            return view('admin.user.add');
        })->name('add-user');

    });
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/', function () {
    return view('home');
});
