<?php

use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function login(LoginRequest $request, AuthService $authService)
    {
        return response()->json(
            $authService->login($request->validated())
        );
    }
}
