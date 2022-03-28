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
    if (\Illuminate\Support\Facades\Auth::check()) {
        return redirect('home');
    } else {
        return view('welcome');
    }
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/lootsheet', [\App\Http\Controllers\LootSheetController::class, 'index'])->name('lootsheet');

Route::middleware('auth')->group(function () {
    Route::middleware('can:edit-users')->group(function () {
        Route::resource('users', UserController::class);
    });
    
    Route::middleware('can:edit-members')->group(function () {
        Route::resource('members', MemberController::class);
    });
});