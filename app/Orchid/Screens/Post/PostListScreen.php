<?php

namespace App\Orchid\Screens\Post;

use App\Models\Post;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;

class PostListScreen extends Screen
{
    public function query(): iterable
    {
        return ['posts' => Post::paginate(),];
    }

    public function name(): ?string
    {
        return 'PostListScreen';
    }

    
    public function description(): ?string
    {
        return 'All registerer posts';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Add')
                ->route('platform.posts.create')
                ->icon('plus'),
        ];
    }

    public function layout(): iterable
    {
        return [Layout::table('posts', [
            TD::make('title', 'Заголовок')->filter(),
            TD::make('text', 'Содержание')->filter(),
            TD::make('user_id', 'Автор')->render(function (Post $post) {
                return $post->user->name ?? 'Неизвестно';
            }),
            TD::make('created_at', 'Создан')->sort(),
            TD::make('Actions', 'Действия')->render(function (Post $post) {
                return
                '<div class="d-flex flex-column gap-2">' .
                    Link::make('Редактировать')
                        ->route('platform.posts.edit', $post)
                        ->class('btn btn-sm')
                        ->render() .

                    Button::make('Удалить')
                        ->confirm('Вы уверены, что хотите удалить этот пост?')
                        ->method('remove', ['id' => $post->id])
                        ->class('btn btn-sm')
                        ->render() .
                    '</div>';
                })
        ]),
        ];
    }
    public function remove(Request $request): void
    {
        $id = $request->get('id');

        if ($post = Post::find($id)) {
            $post->delete();
            Toast::info(__('Post was removed'));
        } else {
            Toast::error(__('Post not found'));
        }
    }
    public function permission(): ?iterable
    {
        return [
            'platform.posts.list',
        ];
    }
}
