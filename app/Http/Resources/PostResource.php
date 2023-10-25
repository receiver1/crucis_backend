<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = auth('sanctum')->user();

        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'text' => $this->text,
            'likes' => $this->likes()->count(),
            'liked' => ($user ? boolval($this->likes()->where('id', $user->id)->count()) : false),
            'comments' => $this->comments()->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'clipped' => (strlen($this->text) == 500),
        ];
    }
}
