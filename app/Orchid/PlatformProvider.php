<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    public function registerMainMenu(): array
    {
        return [
            Menu::make('Users')
                ->icon('user')
                ->route('platform.users')
                ->permission('platform.systems.users'),

            Menu::make('Posts')
                ->icon('note')
                ->route('platform.posts')
                ->permission('platform.posts.list'),

            ];

    }

    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user')
        ];
    }

    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.users', __('Users'))
                ->addPermission('platform.posts.list', __('Posts')),
        ];
    }
}
