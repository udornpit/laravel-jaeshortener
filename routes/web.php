<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShortenController;

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

Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login/handle', [AuthController::class, 'Login'])->name('login.handle'); 
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register/handle', [AuthController::class, 'Registration'])->name('register.handle'); 
Route::get('logout', [AuthController::class, 'logOut'])->name('logout');

Route::post('shorten', [ShortenController::class, 'create'])->name('shorten');
Route::get('shorten/delete/{id}', [ShortenController::class, 'delete'])->name('shorten.delete');
Route::post('shorten/deletebyuser', [ShortenController::class, 'deleteByUser'])->name('shorten.deletebyuser');
Route::get('shorten/clear', [ShortenController::class, 'clear'])->name('shorten.clear');
Route::get('s/{key}', [ShortenController::class, 'toDest']);