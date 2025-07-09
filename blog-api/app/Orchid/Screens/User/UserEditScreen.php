<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserEditScreen extends Screen
{
    public $name = 'Редактирование пользователя';
    public $user;
    public function query(User $user): iterable
    {
        $user->load(['roles']);
        return ['user' => $user];
    }
    public function name(): ?string
    {
        return $this->user->exists ? 'Edit User' : 'Create User';
    }

    public function description(): ?string
    {
        return 'Details such as name, email and password';
    }

    /**
     * @return iterable|null
     */

    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->method('save')
                ->class('btn btn-dark'),
        ];
    }

    public function save(Request $request, User $user)
    {
        $validated = $request->validate([
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|email|unique:users,email,' . $user->id,
            'user.password' => 'nullable|string|min:6',
        ]);

        $user->fill([
            'name' => $validated['user']['name'],
            'email' => $validated['user']['email'],
        ]);

        if (!empty($validated['user']['password'])) {
            $user->password = Hash::make($validated['user']['password']);
        }

        $user->save();

        Toast::info('Пользователь сохранён!');
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('user.name')->title('Имя'),
                Input::make('user.email')->title('Email'),
                Password::make('user.password')->title('Пароль'),
            ]),
        ];
    }
    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }
}
