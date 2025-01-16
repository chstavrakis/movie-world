<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\VoteController;
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
    return redirect()->route('movies.list');
})->name('home');

Route::get('/movies', [MovieController::class, 'list'])
    ->name('movies.list');
Route::get('/movies/create', [MovieController::class, 'create'])
    ->name('movies.create');
Route::post('movies/store', [MovieController::class, 'store'])
    ->middleware(['auth'])->name('movies.store');
Route::post('movies/{movie}/vote', [VoteController::class, 'store'])
    ->middleware(['auth'])->name('movies.vote');
Route::delete('movies/{movie}/vote', [VoteController::class, 'destroy'])
    ->middleware(['auth'])->name('movies.unvote');

require __DIR__.'/auth.php';
