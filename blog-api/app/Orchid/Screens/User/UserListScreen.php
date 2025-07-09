<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'users' => User::paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'User';
    }

    public function description(): ?string
    {
        return 'All registered users';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.users.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('users', [
                TD::make('name', 'Имя'),
                TD::make('email', 'Email'),
                TD::make('updated_at', 'Обновлено'),
                TD::make('Actions')
                    ->render(
                    function(User $user) {
                        return '<div class="d-flex flex-column gap-2">' .
                            Link::make('Редактировать')
                                ->route('platform.users.edit', $user)
                                ->class('btn btn-sm ')
                                ->render().

                            Button::make('Удалить')
                                ->confirm('Вы уверены, что хотите удалить этого пользователя?')
                                ->method('remove', ['id' => $user->id])
                                ->class('btn btn-sm ')
                                ->render() .
                        '</div>';
                    })
            ]),
        ];
    }

    public function asyncGetUser(User $user): iterable
    {
        return [
            'user' => $user,
        ];
    }

    public function saveUser(Request $request, User $user): void
    {
        $request->validate([
            'user.email' => [
                'required',
                Rule::unique(User::class, 'slug')->ignore($user),
            ],
        ]);

        $user->fill($request->input('user'))->save();

        Toast::info(__('User was saved.'));
    }

    public function remove(Request $request): void
    {
        $id = $request->get('id');

        if ($user = User::find($id)) {
            $user->delete();
            Toast::info(__('User was removed'));
        } else {
            Toast::error(__('User not found'));
        }
    }
    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }
}
