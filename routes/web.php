<?php

use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//スケジュール
Route::get('/schedules', 'App\Http\Controllers\ScheduleController@index')->name('schedule.index');
Route::get('/schedules/create', 'App\Http\Controllers\ScheduleController@create')->name('schedule.create')->middleware('auth');
Route::post('/schedules/store/', 'App\Http\Controllers\ScheduleController@store')->name('schedule.store')->middleware('auth');
Route::get('/schedules/edit/{schedule}', 'App\Http\Controllers\ScheduleController@edit')->name('schedule.edit')->middleware('auth');
Route::put('/schedules/edit/{schedule}','App\Http\Controllers\ScheduleController@update')->name('schedule.update')->middleware('auth');
Route::delete('/schedules/{schedule}','App\Http\Controllers\ScheduleController@destroy')->name('schedule.destroy')->middleware('auth');

require __DIR__.'/auth.php';
