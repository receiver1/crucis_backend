<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CommentController extends Controller
{
    public function list(Request $request)
    {
        return Comment::all();
    }

    public function index(Request $request, Comment $comment)
    {
        return $comment;
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'post_id' => 'required|integer|exists:posts',
            'text' => 'required|string',
        ]);

        return Comment::create($data);
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