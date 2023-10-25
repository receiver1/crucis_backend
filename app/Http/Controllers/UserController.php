<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
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

        return UserResource::collection($users->get());
    }

    public function index(Request $request, User $user)
    {
        return new UserResource($user);
    }
}
