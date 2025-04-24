<?php

use App\Http\Controllers\AnimesController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\WatchProgressController;
use App\Http\Controllers\AuthController;
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

// Rotas de autenticação
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rotas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect('/animes');
    });

    Route::resource('animes', AnimesController::class)
        ->except(['show']);

    Route::get('/animes/{anime}/seasons', [SeasonsController::class, 'index'])->name('seasons.index');

    // Rotas de Progresso
    Route::post('/episodes/{episode}/progress', [WatchProgressController::class, 'updateProgress'])->name('progress.update');
    Route::get('/episodes/{episode}/progress', [WatchProgressController::class, 'getProgress'])->name('progress.get');
    Route::post('/seasons/{season}/mark-watched', [WatchProgressController::class, 'markSeasonAsWatched'])->name('progress.mark-season');
});
