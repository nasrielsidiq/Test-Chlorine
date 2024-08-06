<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\CategoryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('login', [AuthApiController::class, 'login']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('jwt.auth')->group(function () {
    Route::post('logout', [AuthApiController::class, 'logout']);
    Route::post('category/add', [CategoryApiController::class, 'create']);
    Route::get('category/get', [CategoryApiController::class, 'get']);
    Route::post('category/update/{id}', [CategoryApiController::class, 'update']);
    Route::get('category/delete/{id}', [CategoryApiController::class, 'delete']);
});
