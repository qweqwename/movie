<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\TagsController;
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

//Главная страница с фильмами
Route::get('/', [MovieController::class, 'index'])->name('movie.index');

//Редактирование фильма
Route::get('/edit/{id}', [MovieController::class, 'edit'])->name('movie.edit');
Route::put('/{id}', [MovieController::class, 'update'])->name('movie.update');

//Создание фильма
Route::get('/create', [MovieController::class, 'create'])->name('movie.create');
Route::post('/', [MovieController::class, 'store'])->name('movie.store');

//Удаление фильма
Route::delete('/{id}', [MovieController::class, 'destroy'])->name('movie.destroy');

//Удаление тега
Route::delete('/tags/{id}', [TagsController::class, 'destroy'])->name('tag.destroy');
