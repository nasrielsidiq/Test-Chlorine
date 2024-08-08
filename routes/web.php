<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
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

Route::get('/login', [UserController::class, 'viewLogin']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('web.auth')->group(function () {
    Route::get('/', function () {
        return view('index');
    });
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/users', [UserController::class, 'users']);
    Route::post('/users/create',[UserController::class, 'create']);
    Route::post('/users/update/{id}',[UserController::class, 'update']);
    Route::get('/users/delete/{id}',[UserController::class, 'delete']);
    Route::get('/categories', [CategoryController::class, 'categories']);
    Route::post('/categories/create', [CategoryController::class, 'create']);
    Route::post('/categories/update/{id}', [CategoryController::class, 'update']);
    Route::get('/categories/delete/{id}', [CategoryController::class, 'delete']);
});
