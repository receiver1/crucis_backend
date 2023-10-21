<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return auth()->user();
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => 'string',
            'last_name' => 'string',
            'avatar_url' => 'string'
        ]);

        User::where('id', auth()->user()->id)
            ->update($data);

        return response('', 204);
    }

    public function remove(Request $request, User $user)
    {
        // TBD
    }
}
