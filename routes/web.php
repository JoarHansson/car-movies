<?php

use App\Http\Controllers\ManageLikesController;
use App\Http\Controllers\GetLikesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GetMoviesController;
use App\Http\Controllers\CreateAccountController;
use App\Http\Controllers\AccountManagerController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DeleteAccountController;
use App\Http\Controllers\DeleteLikeController;

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

// ROUTES FOR GUESTS:
Route::view('/', 'index')->name('login')->middleware('guest');

Route::post('login', LoginController::class)->middleware('guest');

Route::post('createAccount', CreateAccountController::class)->middleware('guest');


// ROUTES FOR USERS:
// General routes
Route::get('dashboard', DashboardController::class)->middleware('auth');

Route::get('logout', LogoutController::class)->middleware('auth');

// Account management routes
Route::get('accountManager', AccountManagerController::class)->middleware('auth');

Route::patch('changePassword', ChangePasswordController::class)->middleware('auth');

Route::delete('deleteAccount', DeleteAccountController::class)->middleware('auth');

// Like view and management routes
Route::get('getLikes', GetLikesController::class)->middleware('auth');

Route::get('manageLike',[ ManageLikesController::class, 'manageLikes'])->middleware('auth');

Route::delete('deleteLike/{like}', DeleteLikeController::class)->middleware('auth');

// Movie querying routes
Route::get('getMovies', [GetMoviesController::class, 'generateMovies'])->middleware('auth');

Route::get("getToplist", [GetMoviesController::class, 'getToplist'])->middleware('auth');

Route::get('returnToPage', [GetMoviesController::class, 'returnToPage'])->middleware('auth');
