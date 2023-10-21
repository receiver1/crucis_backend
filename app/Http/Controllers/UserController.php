<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(Request $request)
    {
        return User::all();
    }

    public function index(Request $request, User $user)
    {
        return $user;
    }
}
