<?php
/*
|--------------------------------------------------------------------------
| Маршруты панели управления
|--------------------------------------------------------------------------
|
| Здесь вы можете зарегистрировать веб-маршруты для своего приложения. Эти
| маршруты загружаются RouteServiceProvider в рамках группы, которая
| содержит необходимую группу промежуточного программного обеспечения «панель управления». Теперь создайте что-нибудь потрясающее!
|
*/

declare(strict_types=1);

use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Post\PostEditScreen;
use App\Orchid\Screens\Post\PostListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');
// screen users
Route::screen('users', UserListScreen::class)
    ->name('platform.users');

Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create');

Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit');

//screen posts
Route::screen('posts', PostListScreen::class)->name('platform.posts');
Route::screen('posts/{post}/edit', PostEditScreen::class)
    ->name('platform.posts.edit');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });


