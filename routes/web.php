<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

/*
Route::get('/', function () {
    return view('welcome');
});
*/


Route::get('/admin/user/getListUsers', 'App\Http\Controllers\Admin\UsersController@getListUsers');
Route::post('/admin/user/setRegisterUser', 'App\Http\Controllers\Admin\UsersController@setRegisterUser');
Route::post('/admin/user/setEditUser', 'App\Http\Controllers\Admin\UsersController@setEditUser');

Route::post('/file/setRegisterFile', 'App\Http\Controllers\FilesController@setRegisterFile');

Route::get('/{optional?}', function () {
    return view('index');
})->name('basepath')
  ->where('optional', '.*');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
