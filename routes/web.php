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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', '\App\Http\Controllers\AttendanceController@index');
Route::resource('attend', \App\Http\Controllers\AttendanceController::class);
Route::get('import-attend', 'App\Http\Controllers\AttendanceController@import')->name('import-attend');
Route::post('store-import', 'App\Http\Controllers\AttendanceController@storeImport')->name('store-import');
Route::post('attend-update/{id}', [\App\Http\Controllers\AttendanceController::class, 'updateAttendance'])->name('attend-update');
Route::get('search-attend', 'App\Http\Controllers\AttendanceController@search')->name('search-attend');
