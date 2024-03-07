<?php

use App\Http\Controllers\ManageLikesController;
use App\Http\Controllers\GetLikesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GetMoviesController;
use App\Http\Controllers\CreateAccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
// */

Route::view('/', 'index')->name('login')->middleware('guest');

Route::post('login', LoginController::class)->middleware('guest');
Route::get('login', LoginController::class)->middleware('guest');

Route::get('logout', LogoutController::class)->middleware('auth');

Route::get('dashboard', DashboardController::class)->middleware('auth');

Route::get('getMovies', [GetMoviesController::class, 'generateMovies'])->middleware('auth');

Route::post('createAccount', CreateAccountController::class)->middleware('guest');

Route::get('getLikes', GetLikesController::class)->middleware('auth');

Route::get('manageLike', ManageLikesController::class)->middleware('auth');

Route::get("getToplist", [GetMoviesController::class, 'getToplist'])->middleware('auth');

Route::get('returnToPage', [GetMoviesController::class, 'returnToPage'])->middleware('auth');