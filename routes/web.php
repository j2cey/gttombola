<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\TirageController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TombolaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomLdapController;
use App\Http\Controllers\BaseParticipationController;

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
    if (Auth::check()) {
        return view('admin02');
    }
    return redirect('/login');
});

Route::get('/home', function () {
    if (Auth::check()) {
        return view('admin02');
    }
    return redirect('/login');
});

Auth::routes();

Route::prefix('ldap')->group(function(){
    Route::get('/test', [CustomLdapController::class,'test'])->name('ldaptest');
    Route::get('/sync', [CustomLdapController::class,'sync'])->name('ldapsync');
});

// Route pour test de Master/Details avec Vuejs et VueX
Route::get('persons', [PersonController::class,'index']);

Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product/fetch', [ProductController::class, 'fetch'])->name('product.fetch');
Route::get('/product/{product_id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::get('/product/{product_id}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');

Route::resource('tombolas',TombolaController::class)->middleware('auth');
Route::get('/tombola/fetch', [TombolaController::class, 'fetch'])->name('tombola.fetch');
Route::get('/tombola/geturnes/{tombola_id}', [TombolaController::class, 'getUrnes'])->name('tombola.getUrnes');

Route::resource('baseparticipations',BaseParticipationController::class)->middleware('auth');
Route::resource('tirages',TirageController::class)->middleware('auth');

Route::get('permissions',[RoleController::class, 'permissions'])->middleware('auth');
Route::resource('roles',RoleController::class)->middleware('auth');
Route::get('hasrole/{roleid}',[RoleController::class, 'hasrole'])->middleware('auth');
Route::resource('users',UserController::class)->middleware('auth');

//Route::get('/home', 'HomeController@index')->name('home');

Route::resource('settings',SettingController::class);

Route::resource('users',UserController::class)->middleware('auth');
Route::get('users.fetch',[UserController::class,'fetch'])
    ->name('users.fetch')
    ->middleware('auth');
