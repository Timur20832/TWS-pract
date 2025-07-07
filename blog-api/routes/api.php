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

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::apiResource('posts', PostController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/* бета-тестирование */

Route::get('/posts', [PostController::class, 'index']);
