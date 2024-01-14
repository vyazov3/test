<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(User $user)
    {
        $user = UserResource::make($user)->resolve();
        return inertia('User/Profile', compact('user'));
    }
}
