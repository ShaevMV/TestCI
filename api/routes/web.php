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

// обработка запросов с vue-router
Route::get('/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '^(?!(?:admin))[\/\w\.-]*');



Route::get('/admin/{any?}', '\App\Http\Controllers\AdminController@index')->where('any', '.*');
