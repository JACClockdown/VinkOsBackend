<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomeworksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::group([ 'middleware' => ['jwt']], function(){

    Route::controller(HomeworksController::class)->group(function() {
        Route::get('/homeworks','index')->name('homeworks.index');
        Route::post('/homework','store')->name('homeworks.store');
        Route::get('/homework/{id}','me')->name('homeworks.get');
        Route::put('/homework/{id}','update')->name('homeworks.update');
        Route::delete('/homework/{id}','delete')->name('homeworks.delete');
    });

    

});