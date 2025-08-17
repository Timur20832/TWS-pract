<?php
namespace App\Services;

use App\DTO\Auth\LoginDto;
use App\DTO\Auth\RegisterDto;
use App\Models\User;
use Orchid\Platform\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(RegisterDto $dto): string
    {
        // Проверка на существующего пользователя
        if (User::where('email', $dto->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => ['Пользователь с таким email уже существует.'],
            ]);
        }

        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);

        // Автоматически назначаем роль "user" новому пользователю
        $userRole = Role::where('slug', 'user')->first();
        if ($userRole) {
            $user->roles()->attach($userRole);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $token;
    }

    public function login(LoginDto $dto): string
    {
        $user = User::where('email', $dto->email)->first();

        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Incorrect email or password.'],
            ]);
        }

        return $user->createToken('auth_token')->plainTextToken;
    }
    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }

    public function me(User $user): array
    {
        return [
            'id' => $user->__get('id'),
            'name' => $user->__get('name'),
            'email' => $user->__get('email'),
        ];
    }
}
