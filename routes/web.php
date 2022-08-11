<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Providers\RouteServiceProvider;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\FullCalenderController;



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
Route::get('phpmyinfo', function () {
    phpinfo(); 
})->name('phpmyinfo');

Route::get('/symbolic-link', function () {
    Artisan::call('storage:link');
});

Route::get('/login','App\Http\Controllers\LoginController@formlogin')->name('login')->middleware('guest');
Route::post('/login','App\Http\Controllers\LoginController@actionLogin')->name('action.login');

Route::get('/','App\Http\Controllers\DashboardController@index')->name('dashboard.index');
Route::get('/logout','App\Http\Controllers\DashboardController@logout')->name('logout');

Route::get('/users','App\Http\Controllers\UserController@index')->name('dashboard.users.index');
Route::post('/users/create','App\Http\Controllers\UserController@store')->name('dashboard.users.create');
Route::post('/users/edit','App\Http\Controllers\UserController@edit')->name('dashboard.users.edit');
Route::post('/users/update','App\Http\Controllers\UserController@update')->name('dashboard.users.update');
Route::post('/users/delete','App\Http\Controllers\UserController@destroy')->name('dashboard.users.delete');

Route::get('/attendances','App\Http\Controllers\AttendanceController@index')->name('dashboard.attendances.index');
Route::post('/attendances/start','App\Http\Controllers\AttendanceController@startWork')->name('dashboard.attendances.start');
Route::post('/attendances/finish','App\Http\Controllers\AttendanceController@finishWork')->name('dashboard.attendances.finish');

Route::get('/outlets','App\Http\Controllers\OutletController@index')->name('outlet.index');
Route::post('/outlets/create','App\Http\Controllers\OutletController@store')->name('outlet.create');
Route::post('/outlets/edit','App\Http\Controllers\OutletController@edit')->name('outlet.edit');
Route::post('/outlets/update','App\Http\Controllers\OutletController@update')->name('outlet.update');
Route::post('/outlet/delete','App\Http\Controllers\OutletController@destroy')->name('outlet.delete');

Route::get('/useroutlets','App\Http\Controllers\UserOutletController@index')->name('useroutlet.index');
Route::post('/useroutlets/create','App\Http\Controllers\UserOutletController@store')->name('useroutlet.create');
Route::post('/useroutlets/edit','App\Http\Controllers\UserOutletController@edit')->name('useroutlet.edit');
Route::post('/useroutlets/update','App\Http\Controllers\UserOutletController@update')->name('useroutlet.update');
Route::post('/useroutlets/delete','App\Http\Controllers\UserOutletController@destroy')->name('useroutlet.delete');

Route::resource('/posts', \App\Http\Controllers\PostController::class);

Route::get('dropdown', [DropdownController::class, 'index']);
Route::post('api/fetch-useroutlet',[DropdownController::class, 'fetchUserOutlet']);

Route::resource('/event', \App\Http\Controllers\FullCalenderController::class);
Route::post('eventAjax', [FullCalenderController::class, 'ajax']);

