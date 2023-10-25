<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class PostController extends Controller
{
    /**
     * @response array{"data": array{PostResource}, "links": array{"first": "http://127.0.0.1:8000/api/v1/posts?page=1", "last": "http://127.0.0.1:8000/api/v1/posts?page=1", "prev": null, "next": null}}
     */
    public function list(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'integer|exists:users,id',
            'sort' => 'array|in:created_at,updated_at,likes_count',
            'count' => 'integer|gte:0|lte:100'
        ]);

        $posts = Post::select(\DB::raw('*, SUBSTR(text, 1, 500) as text'))
            ->withCount('likes');
        if ($request->has('user_id'))
            $posts->where('user_id', $data['user_id']);

        if ($request->has('sort'))
            foreach ($data['sort'] as &$item)
                $posts->orderBy($item, 'desc');

        return PostResource::collection(
            $posts->simplePaginate($request->has('count') ? $data['count'] : 12)
        );
    }

    public function index(Request $request, $id)
    {
        $post = Post::query()
            ->where('id', $id)
            ->withCount('likes')
            ->first();

        return new PostResource($post);
    }

    public function like(Request $request, Post $post)
    {
        if ($post->likes()->where('user_id', $request->user()->id)->count())
            throw new ConflictHttpException('Вы уже поставили лайк на этот пост');

        $post->likes()->attach($request->user()->id);
        return response()->json('', 204);
    }

    public function unlike(Request $request, Post $post)
    {
        if (!$post->likes()->where('user_id', $request->user()->id)->count())
            throw new ConflictHttpException('Вы не ставили лайк на этот пост');

        $post->likes()->detach($request->user()->id);
        return response()->json('', 204);
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

        $post->update($data);
        return new PostResource($post);
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
