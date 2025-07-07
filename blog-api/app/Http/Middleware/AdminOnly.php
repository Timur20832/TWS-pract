<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

namespace App\Http\Middleware;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !$user->hasAccess('platform.systems.users')) { // или твоя проверка роли
            abort(403, 'Доступ запрещён для неадминистратора');
        }

        return $next($request);
    }
}
