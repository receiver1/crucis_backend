<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @response array{"data": array{UserResource}, "links": array{"first": "http://127.0.0.1:8000/v1/users?page=1", "last": "http://127.0.0.1:8000/v1/users?page=1", "prev": null, "next": null}}
     */
    public function list(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|max:100',
        ]);

        $users = User::query();
        if ($request->has('name'))
            $users->where(function ($query) use ($data) {
                $query->where('first_name', 'like', '%' . $data['name'] . '%')
                    ->orWhere('last_name', 'like', '%' . $data['name'] . '%');
            });

        return UserResource::collection(
            $users->simplePaginate($request->has('count') ? $data['count'] : 12)
        );
    }

    public function index(Request $request, User $user)
    {
        return new UserResource($user);
    }
}
