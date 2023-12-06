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
    //投稿一覧画面表示（top画面）
    Route::get('', [App\Http\Controllers\KnowledgeController::class, 'index'])->name('index');
    //ログアウト処理
    Route::get('logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
    // 新規投稿画面に遷移
    Route::get('post', [App\Http\Controllers\KnowledgeController::class, 'create'])->name('create');
    // 新規投稿処理を行い、投稿一覧画面に遷移する。
    Route::post('', [App\Http\Controllers\KnowledgeController::class, 'createPost'])->name('createPost');
    // 投稿編集画面に遷移
    Route::get('{id}/edit', [App\Http\Controllers\KnowledgeController::class, 'showEdit'])->name('edit');
    //投稿詳細画面に遷移
    Route::get('{id}', [App\Http\Controllers\KnowledgeController::class, 'KnowledgeDetail'])->name('detail');
    // 投稿削除処理
    Route::delete('{id}', [App\Http\Controllers\KnowledgeController::class, 'deletePost'])->name('delete');
    //投稿編集処理をし、投稿詳細画面に遷移
    Route::put('{id}', [App\Http\Controllers\KnowledgeController::class, 'updatePost'])->name('update');
});





