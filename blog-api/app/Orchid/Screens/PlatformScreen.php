<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    public function query(): iterable
    {
        return [];
    }

    public function name(): ?string
    {
        return 'its main';
    }

    public function description(): ?string
    {
        return 'Welcome to your Orchid application.';
    }

    public function layout(): iterable
    {
        return [];
    }
}
