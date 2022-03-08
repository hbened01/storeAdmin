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
Route::post('/admin/user/setChangeStatusUser', 'App\Http\Controllers\Admin\UsersController@setChangeStatusUser');
Route::post('/admin/user/setEditRolByUser', 'App\Http\Controllers\Admin\UsersController@setEditRolByUser');
Route::post('/admin/user/setRegisterRolePermitByUser', 'App\Http\Controllers\Admin\UsersController@setRegisterRolePermitByUser');
Route::get('/admin/user/getRoleByUser', 'App\Http\Controllers\Admin\UsersController@getRoleByUser');
Route::get('/admin/user/getListPermitByRolAsign', 'App\Http\Controllers\Admin\UsersController@getListPermitByRolAsign');
Route::get('/admin/user/getListPermissionsByUser', 'App\Http\Controllers\Admin\UsersController@getListPermissionsByUser');

Route::get('/admin/role/getlistRoles', 'App\Http\Controllers\Admin\RolesController@getlistRoles');
Route::get('/admin/role/getListPermissionsByRole', 'App\Http\Controllers\Admin\RolesController@getListPermissionsByRole');
Route::post('/admin/role/setRegisterRolePermit', 'App\Http\Controllers\Admin\RolesController@setRegisterRolePermit');
Route::post('/admin/role/setRegisterEditRolePermit', 'App\Http\Controllers\Admin\RolesController@setRegisterEditRolePermit');

Route::get('/admin/permit/getListPermissions', 'App\Http\Controllers\Admin\PermittionsController@getListPermissions');
Route::post('/admin/permit/setRegisterPermit', 'App\Http\Controllers\Admin\PermittionsController@setRegisterPermit');
Route::post('/admin/permit/setEditPermit', 'App\Http\Controllers\Admin\PermittionsController@setEditPermit');

Route::post('/file/setRegisterFile', 'App\Http\Controllers\FilesController@setRegisterFile');

Route::get('/{optional?}', function () {
    return view('index');
})->name('basepath')
  ->where('optional', '.*');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
