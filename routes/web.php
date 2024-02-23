<?php

use App\Http\Controllers\AnimesController;
use App\Http\Controllers\SeasonsController;
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
    return redirect('/animes');
});

Route::resource('animes', AnimesController::class)
    ->except(['show']);

Route::get('/animes/{anime}/seasons', [SeasonsController::class, 'index'])->name('seasons.index');
