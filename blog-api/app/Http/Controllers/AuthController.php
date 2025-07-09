<?php

namespace App\Http\Controllers;

use App\DTO\Auth\LoginDto;
use App\DTO\Auth\RegisterDto;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = new RegisterDto(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        $token = $this->authService->register($dto);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }
    public function login(LoginRequest $request): JsonResponse
    {
        $dto = new LoginDto(
            $request->input('email'),
            $request->input('password')
        );

        $token = $this->authService->login($dto);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'Logged out'], 200);
    }


    public function me(Request $request): JsonResponse
    {
        $userData = $this->authService->me($request->user());

        return response()->json($userData, 200);
    }
}
