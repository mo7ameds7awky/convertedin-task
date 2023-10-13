<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Selectors\UserSelectorController;
use App\Http\Controllers\Tasks\IndexStatisticsController;
use App\Http\Controllers\Tasks\TaskController;
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
    return redirect()->route('tasks.index');
});

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
    Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/create', [TaskController::class, 'create'])->name('create');
        Route::post('/', [TaskController::class, 'store'])->name('store');
    });
    Route::get('statistics', IndexStatisticsController::class)->name('statistics');
    Route::group(['prefix' => 'selectors', 'as' => 'selectors.'], function () {
        Route::get('/users', UserSelectorController::class)->name('users');
    });
});

require __DIR__.'/auth.php';
