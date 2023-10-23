<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CommentController extends Controller
{
    /**
     * @response array{"data": array{CommentResource}, "links": array{"first": "http://127.0.0.1:8000/api/v1/posts?page=1", "last": "http://127.0.0.1:8000/api/v1/posts?page=1", "prev": null, "next": null}}
     */
    public function list(Request $request)
    {
        $data = $request->validate([
            'post_id' => 'required|integer|exists:posts,id',
            'count' => 'integer|gte:0|lte:100',
        ]);

        $comments = Comment::query();
        $comments->where('post_id', $data['post_id']);
        $comments->orderBy('created_at');

        return CommentResource::collection(
            $comments->simplePaginate(array_key_exists('count', $data) ? $data['count'] : 12)
        );
    }

    public function index(Request $request, Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'post_id' => 'required|integer|exists:posts',
            'text' => 'required|string',
        ]);

        $data['user_id'] = auth()->user()->id;
        return new CommentResource(Comment::create($data));
    }

    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'text' => 'required|string',
        ]);

        if ($comment->user_id != auth()->user()->id)
            throw new AccessDeniedHttpException('Недостаточно прав');

        Comment::where('id', $comment->id)
            ->update($data);

        return response('', 204);
    }

    public function remove(Request $request, Comment $comment)
    {
        if ($comment->user_id != auth()->user()->id)
            throw new AccessDeniedHttpException('Недостаточно прав');

        Comment::destroy($comment->id);
        return response('', 204);
    }
}