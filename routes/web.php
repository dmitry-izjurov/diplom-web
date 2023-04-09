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
Route::get('/home', [\App\Http\Controllers\HallsController::class, 'index'])->name('halls.index');
Route::post('home/', [\App\Http\Controllers\HallsController::class, 'store'])->name('halls.store');
Route::patch('/update-hall', [\App\Http\Controllers\HallsController::class, 'update'])->name('halls.update');
Route::delete('/delete-hall/{id}', [\App\Http\Controllers\HallsController::class, 'destroy'])->name('halls.destroy');

Route::get('/laravel', function () {
    return view('welcome');
});
