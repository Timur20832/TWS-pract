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
    /**
     * Публикация поста от имени пользователя.
     * @param User $user
     * @param CreatePostDto $dto
     * @return Post
     */
    public function createPost(User $user, CreatePostDto $dto): Post
    {
        // В ТЗ поле называется text, но в модели Post оно обычно content.
        // Здесь предполагается, что CreatePostDto::content соответствует text из запроса.
        $post = new Post();
        $post->title = $dto->title;
        $post->content = $dto->content; // dto->content = text из запроса
        $post->user_id = $user->id;

        $post->save();

        return $post;
    }

    /**
     * Получение всех публикаций с поддержкой пагинации, сортировки и фильтрации по дате.
     * @param PostQueryDto $query
     * @return Collection
     */
    public function getAllPosts(PostQueryDto $query): Collection
    {
        // Порционная выдача: limit и offset, сортировка, фильтрация по дате
        return $this->buildPostQuery($query)->get();
    }

    /**
     * Получение публикаций текущего пользователя с поддержкой пагинации, сортировки и фильтрации по дате.
     * @param User $user
     * @param PostQueryDto $query
     * @return Collection
     */
    public function getUserPosts(User $user, PostQueryDto $query): Collection
    {
        return $this->buildPostQuery($query)
            ->where('user_id', $user->id)
            ->get();
    }

    /**
     * Построение запроса для публикаций с учетом фильтрации, сортировки и пагинации.
     * @param PostQueryDto $query
     * @return Builder
     */
    private function buildPostQuery(PostQueryDto $query): Builder
    {
        $qb = Post::query();

        // Фильтрация по дате (от, до)
        if ($query->dateFrom) {
            $qb->where('created_at', '>=', $query->dateFrom);
        }
        if ($query->dateTo) {
            $qb->where('created_at', '<=', $query->dateTo);
        }

        // Поддержка нескольких вариантов сортировки: по дате или по названию/заголовку
        $allowedSortFields = ['created_at', 'title'];
        $sortBy = in_array($query->sortBy, $allowedSortFields) ? $query->sortBy : 'created_at';
        $sortOrder = in_array(strtolower($query->sortOrder), ['asc', 'desc']) ? strtolower($query->sortOrder) : 'desc';

        // Порционная выдача: limit и offset, по умолчанию limit = 10
        $limit = $query->limit ?? 10;
        if ($limit <= 0) {
            $limit = 10;
        }
        $offset = $query->offset ?? 0;
        if ($offset < 0) {
            $offset = 0;
        }

        return $qb
            ->orderBy($sortBy, $sortOrder)
            ->limit($limit)
            ->offset($offset);
    }
}
