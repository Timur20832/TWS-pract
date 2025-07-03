<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    public function login(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return ['error' => 'Invalid email or password'];
        }

        $token = Str::random(60);  // Просто для примера. Реально лучше использовать Laravel Sanctum или Passport

        // Пример простой генерации токена
        return [
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ];
    }
}
