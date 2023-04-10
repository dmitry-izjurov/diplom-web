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

Route::get('/', function () {
    return view('main');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::post('/create-hall', [\App\Http\Controllers\HallsController::class, 'store'])->name('halls.store');
Route::patch('/update-hall', [\App\Http\Controllers\HallsController::class, 'update'])->name('halls.update');
Route::delete('/delete-hall/{id}', [\App\Http\Controllers\HallsController::class, 'destroy'])->name('halls.destroy');
Route::post('/add-film', [\App\Http\Controllers\FilmController::class, 'store'])->name('films.store');
Route::delete('/delete-film/{id}', [\App\Http\Controllers\FilmController::class, 'destroy'])->name('films.destroy');

Route::get('/laravel', function () {
    return view('welcome');
});
