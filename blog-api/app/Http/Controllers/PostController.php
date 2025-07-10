<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\DTO\Post\CreatePostDto;
use App\DTO\Post\PostQueryDto;
use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    public function create(CreatePostRequest $request): JsonResponse
    {
        $dto = new CreatePostDto(
            $request->input('title'),
            $request->input('content')
        );

        $post = $this->postService->createPost($request->user(), $dto);

        return response()->json(new PostResource($post), 201);
    }

    public function all(Request $request): JsonResponse
    {
        $dto = new PostQueryDto(
            $request->query('sort_by', 'created_at'),
            $request->query('sort_order', 'desc'),
            $request->query('limit', 10),
            $request->query('offset', 0),
            $request->query('date_from'),
            $request->query('date_to'),
        );

        $posts = $this->postService->getAllPosts($dto);

        return response()->json(PostResource::collection($posts), 200);
    }

    public function my(Request $request): JsonResponse
    {
        $dto = new PostQueryDto(
            $request->query('sort_by', 'created_at'),
            $request->query('sort_order', 'desc'),
            $request->query('limit', 10),
            $request->query('offset', 0),
            $request->query('date_from'),
            $request->query('date_to'),
        );

        $posts = $this->postService->getUserPosts($request->user(), $dto);

        return response()->json(PostResource::collection($posts), 200);
    }
}
