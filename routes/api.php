<?php
/*
|--------------------------------------------------------------------------
| Маршруты API
|--------------------------------------------------------------------------
|
| Здесь вы можете зарегистрировать маршруты API для своего приложения. Эти
| маршруты загружаются RouteServiceProvider в рамках группы, которой
| назначена группа промежуточного программного обеспечения «api». Наслаждайтесь созданием своего API!
|
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::prefix('posts')->group(function () {
    Route::post('/', [PostController::class, 'create'])->middleware('auth:sanctum');
    Route::get('/', [PostController::class, 'all']);
    Route::get('/my', [PostController::class, 'my'])->middleware('auth:sanctum');
});
