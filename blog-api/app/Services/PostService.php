<?php
namespace App\Services;

use App\DTO\Post\CreatePostDto;
use App\DTO\Post\PostQueryDto;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PostService
{
    public function createPost(User $user, CreatePostDto $dto): Post
    {
        // Создаем новый пост и присваиваем поля явно, чтобы избежать ошибок
        $post = new Post();
        $post->title = $dto->title;
        $post->text = $dto->text;
        $post->user_id = $user->id;  // связываем пост с пользователем

        $post->save();

        return $post;
    }

    public function getAllPosts(PostQueryDto $query): Collection
    {
        return $this->buildPostQuery($query)->get();
    }

    public function getUserPosts(User $user, PostQueryDto $query): Collection
    {
        return $this->buildPostQuery($query)
            ->where('user_id', $user->id)
            ->get();
    }

    private function buildPostQuery(PostQueryDto $query): Builder
    {
        $qb = Post::query();

        if ($query->dateFrom) {
            $qb->where('created_at', '>=', $query->dateFrom);
        }
        if ($query->dateTo) {
            $qb->where('created_at', '<=', $query->dateTo);
        }

        return $qb
            ->orderBy($query->sortBy ?? 'created_at', $query->sortOrder ?? 'desc')
            ->limit($query->limit ?? 10)
            ->offset($query->offset ?? 0);
    }
}
