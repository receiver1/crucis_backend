<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PostController extends Controller
{
    /**
     * @response array{"data": array{PostResource}, "links": array{"first": "http://127.0.0.1:8000/api/v1/posts?page=1", "last": "http://127.0.0.1:8000/api/v1/posts?page=1", "prev": null, "next": null}}
     */
    public function list(Request $request)
    {
        $data = $request->validate([
            'count' => 'integer|gte:0|lte:100'
        ]);

        return PostResource::collection(
            Post::paginate(array_key_exists('count', $data) ? $data['count'] : 12)
        );
    }

    public function index(Request $request, Post $post)
    {
        return new PostResource($post);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'text' => 'required|string',
        ]);

        $data['user_id'] = auth()->user()->id;
        return new PostResource(Post::create($data));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'text' => 'required|string',
        ]);

        if ($post->user_id != auth()->user()->id)
            throw new AccessDeniedHttpException('Недостаточно прав');

        Post::where('id', $post->id)
            ->update($data);

        return response('', 204);
    }

    public function remove(Request $request, Post $post)
    {
        $user = auth()->user();
        if ($post->user_id != $user->id && !$user->tokenCan('posts:remove'))
            throw new AccessDeniedHttpException('Недостаточно прав');

        Post::destroy($post->id);
        return response('', 204);
    }
}
