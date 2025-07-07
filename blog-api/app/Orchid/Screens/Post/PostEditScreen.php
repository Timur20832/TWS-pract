<?php

namespace App\Orchid\Screens\Post;

use App\Models\Post;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostEditScreen extends Screen
{
    public $post;

    public function query(Post $post): iterable
    {
        $this->post = $post;
        return [
            'post' => $post
        ];
    }

    public function name(): ?string
    {
        return $this->post->exists ? 'Edit post' : 'Create post';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->method('save')
                ->class('btn btn-primary'),
            Button::make('Удалить')
                ->method('remove')
                ->confirm('Вы уверены, что хотите удалить этот пост?')
                ->canSee($this->post->exists),
        ];
    }


    public function layout(): iterable
    {
        return array(
            Layout::rows(array(
                Input::make('post.title')
                    ->title('Заголовок')
                    ->placeholder('Введите заголовок')
                    ->required(),

                Textarea::make('post.content')
                    ->title('Содержание')
                    ->placeholder('Введите содержание')
                    ->rows(10)
                    ->required(),
            )),
        );
    }

    // Метод сохранения
    public function save(Post $post, Request $request)
    {
        $post->fill($request->input('post'));
        $post->save();

        Toast::info('Пост успешно сохранён');

        return redirect()->route('platform.posts.edit', $post->id);
    }

    // Метод удаления
    public function remove(Post $post)
    {
        $post->delete();

        Toast::info('Пост удалён');

        return redirect()->route('platform.posts');
    }
}
