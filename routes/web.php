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
    return view('welcome');
});

Route::view('/json', 'json');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\ChatController;

Route::get('/chat/{receive}', [App\Http\Controllers\ChatController::class, 'index'])->name('chat');
Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'store'])->name('chatSend');