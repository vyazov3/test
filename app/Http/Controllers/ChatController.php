<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    private function findNameChat($chat_id)
    {
        return ChatUser::where('chat_id', 6)->first()->chat->title;
    }

    private function findUsersInChat($chat_id)
    {
        $users = ChatUser::where('chat_id', $chat_id)->get();
        foreach ($users as $user) {
            $user['name'] = $user->user->name;
        }
        return UserResource::collection($users)->resolve();
    }

    private function inviteChat($user_id, $chat_id)
    {
        ChatUser::insert([
            'user_id' => $user_id,
            'chat_id' => $chat_id
        ]);
    }

    private function createChatName()
    {
        return Chat::updateOrCreate(
            ['title'=>'name'],
            ['title'=>'name']
        )->id;
    }

    public function createChat(User $user)
    {
        $chat_id = $this->createChat()->id;
        $this->inviteChat($user->id, $chat_id);
        $this->inviteChat(Auth::user()->id, $chat_id);
        $users = $this->findUsersInChat($chat_id);

        return redirect()->route('messages.index');
    }
    public function index(User $user)
    {
//        $this->createChat($user);
        $user = UserResource::make($user)->resolve();
        return inertia('User/Profile', compact('user'));
//        return redirect()->route('messages.index', ['user' => $users]);
    }
}
