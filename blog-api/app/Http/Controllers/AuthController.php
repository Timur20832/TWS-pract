<?php

namespace App\Http\Controllers;

use AuthService;
use Illuminate\Routing\Controller;
use LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request, AuthService $authService)
    {
        return response()->json(
            $authService->login($request->validated())
        );
    }
}
