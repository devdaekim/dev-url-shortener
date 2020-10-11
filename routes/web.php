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
//     return view('components.layouts.app');
// });


Route::middleware('auth')->group(function () {
  Route::get('/', App\Http\Livewire\ShortenedLink::class);
  Route::get('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
  })->name('logout');
});

Route::middleware('guest')->group(function () {
  Route::get('/register', App\Http\Livewire\Auth\Register::class)->name('register');
  Route::get('/login', App\Http\Livewire\Auth\Login::class)->name('login');
});
