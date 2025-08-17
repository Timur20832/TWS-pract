<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostEditScreen extends Screen
{
    public $name = 'Редактирование публикации';
    public $post;

    public function query(Post $post = null): iterable
    {
        $this->post = $post ?? new Post();
        if ($this->post->exists) {
            $this->post->load(['user']);
        }
        return ['post' => $this->post];
    }

    public function name(): ?string
    {
        return $this->post->exists ? 'Edit Post' : 'Create Post';
    }

    public function description(): ?string
    {
        return 'Details such as title, text and author';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->method('save')
                ->class('btn btn-dark'),
        ];
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'post.title' => 'required|string|max:255',
            'post.text' => 'required|string|min:10|max:1000',
            'post.user_id' => 'required|exists:users,id',
        ]);

        $this->post->fill([
            'title' => $validated['post']['title'],
            'text' => $validated['post']['text'],
            'user_id' => $validated['post']['user_id'],
        ]);

        $this->post->save();

        Toast::info('Публикация сохранена!');
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('post.title')->title('Заголовок'),
                Select::make('post.user_id')
                    ->title('Автор')
                    ->fromModel(\App\Models\User::class, 'name')
                    ->empty('Выберите автора')
                    ->help('Выберите автора публикации'),
                TextArea::make('post.text')
                    ->title('Содержание')
                    ->rows(10)
                    ->help('Минимум 10 символов, максимум 1000 символов'),
            ]),
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.posts.list',
        ];
    }
}
