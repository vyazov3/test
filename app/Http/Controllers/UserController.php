<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        $users = UserResource::collection($users)->resolve();
        return inertia('User/Index', compact('users'));
    }
}
