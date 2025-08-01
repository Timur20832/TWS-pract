<?php

/*
|--------------------------------------------------------------------------
| Создание приложения
|--------------------------------------------------------------------------
|
| Первое, что мы сделаем, — это создадим новый экземпляр приложения Laravel.
| Он служит «клеем» для всех компонентов Laravel и является
| контейнером IoC для системы, связывающей все её части.
|
|
|--------------------------------------------------------------------------
| Привязка важных интерфейсов
|--------------------------------------------------------------------------
|
| Далее нам нужно привязать к контейнеру несколько важных интерфейсов, чтобы
| мы могли обращаться к ним при необходимости. Ядра обрабатывают
| входящие запросы к этому приложению как через веб-интерфейс, так и через интерфейс командной строки.
|
*/
$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
