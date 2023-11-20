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
    return view('auth.register');
});

Route::group(['prefix' => 'auth/{provider}', 'as' => 'sns' ], function () {
    Route::get('/redirect', [App\Http\Controllers\LoginController::class, 'redirectToProvider'])->name('.redirect');
    Route::get('/callback', [App\Http\Controllers\LoginController::class, 'handleProviderCallback'])->name('.callback');
});

Route::group(['prefix' => 'Knowledge', 'as' => 'Knowledge.', 'middleware' => 'auth'], function() {
    Route::get('', [App\Http\Controllers\KnowledgeController::class, 'index'])->name('index');
});




