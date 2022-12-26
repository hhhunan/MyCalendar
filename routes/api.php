<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\CalendarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::prefix('calendar')->group(function (){
    Route::get('/', [CalendarController::class, 'getBetweenDatesAction']);
    Route::patch('/update/{id}', [CalendarController::class, 'updateAction']);
    Route::delete('/{id}', [CalendarController::class, 'destroyAction']);
})->middleware('auth');
Route::post('/calendar', [CalendarController::class, 'createAction']);
Route::get('/calendar/{id}', [CalendarController::class, 'getAction']);
//Route::apiResource('/calendar', CalendarController::class);

