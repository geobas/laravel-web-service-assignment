<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['debugbar'], 'prefix' => 'v1'], function () {
    Route::apiResources([
        'articles' => ArticleController::class,
        'comments' => CommentController::class,
    ]);

    Route::get('/articles/send/all', [ArticleController::class, 'sendAll'])->name('articles.send.all');
});
