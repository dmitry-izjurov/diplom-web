<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['register' => false]);

Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('main.index');
Route::get('/seance/{id}', [\App\Http\Controllers\MainController::class, 'show'])->name('main.show');
Route::patch('/seance/{id}', [\App\Http\Controllers\MainController::class, 'update'])->name('main.update');
Route::get('/seance/{id}/payment', [\App\Http\Controllers\SeanceController::class, 'show'])->name('seance.show');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::post('/create-hall', [\App\Http\Controllers\HallController::class, 'store'])->name('halls.store');
Route::patch('/update-hall', [\App\Http\Controllers\HallController::class, 'update'])->name('halls.update');
Route::delete('/delete-hall/{id}', [\App\Http\Controllers\HallController::class, 'destroy'])->name('halls.destroy');
Route::post('/add-film', [\App\Http\Controllers\FilmController::class, 'store'])->name('films.store');
Route::delete('/delete-film/{id}', [\App\Http\Controllers\FilmController::class, 'destroy'])->name('films.destroy');
Route::post('/add-seance', [\App\Http\Controllers\SeanceController::class, 'store'])->name('seance.store');
Route::delete('/delete-seance/{id}', [\App\Http\Controllers\SeanceController::class, 'destroy'])->name('seance.destroy');

Route::get('/laravel', function () {
    return view('welcome');
});
