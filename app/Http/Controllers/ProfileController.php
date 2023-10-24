<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return new UserResource($request->user());
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => 'string',
            'last_name' => 'string',
            'avatar_url' => 'string'
        ]);

        $user->update($data);
        return new UserResource($user);
    }

    public function remove(Request $request, User $user)
    {
        // TBD
    }
}
