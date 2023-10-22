<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(Request $request)
    {
        return UserResource::collection(User::all());
    }

    public function index(Request $request, User $user)
    {
        return new UserResource($user);
    }
}
