<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\WordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return response()->json(['message' => 'Fullstack Challenge 🏅 - Dictionary']);
});

Route::post('/auth/signup', [AuthController::class, 'signUp']);
Route::post('/auth/signin', [AuthController::class, 'signIn']);

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('/entries/en', [WordController::class, 'index']);
    Route::get('/entries/en/{word}', [WordController::class, 'show']);

    Route::post('/entries/en/{word}/favorite', [FavoriteController::class, 'store']);
    Route::delete('/entries/en/{word}/unfavorite', [FavoriteController::class, 'destroy']);
    Route::get('/user/me/favorites', [FavoriteController::class, 'index']);

    Route::get('/user/me', [AuthController::class, 'show']);
    Route::get('/user/me/history', [HistoryController::class, 'index']);
});

