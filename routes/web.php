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

Route::get('/', function () {
    return view('welcome');
});

// REFACTOR
//Route::resource('/administrar/categoria','App\Http\Controllers\CategoriaController');

// NO REFACTOR

Route::post('/administrar/categoria/crear','App\Http\Controllers\CategoriaController@store');

Route::get('/administrar/categoria','App\Http\Controllers\CategoriaController@index');

Route::get('/administrar/categoria/{categoria}','App\Http\Controllers\CategoriaController@show');

Route::put('/administrar/categoria/actualizar/{categoria}','App\Http\Controllers\CategoriaController@update');

Route::delete('/administrar/categoria/eliminar/{categoria}','App\Http\Controllers\CategoriaController@destroy');