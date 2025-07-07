<?php
/*
|--------------------------------------------------------------------------
| Веб-маршруты
|--------------------------------------------------------------------------
|
| Здесь вы можете зарегистрировать веб-маршруты для своего приложения. Эти
| маршруты загружаются RouteServiceProvider в рамках группы, которая
| содержит группу промежуточного программного обеспечения «веб». Теперь создайте что-нибудь потрясающее!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/logout', function () {
    Auth::logout();           // Выход пользователя
    request()->session()->invalidate();  // Инвалидируем сессию
    request()->session()->regenerateToken(); // Обновляем CSRF токен
    return redirect('/login'); // Перенаправляем на страницу входа
})->name('logout');
