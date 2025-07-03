<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
class PostController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Post::all());
    }

    public function store(Request $request)
    {
        $post = Post::create($request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'user_id' => 'required|integer',
        ]));

        return response()->json($post, 201);
    }

    public function show($id)
    {
        return response()->json(Post::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->validate([
            'title' => 'string',
            'content' => 'string',
            'user_id' => 'integer',
        ]));

        return response()->json($post);
    }

    public function destroy($id)
    {
        Post::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
