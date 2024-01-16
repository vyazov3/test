<?php

namespace App\Http\Controllers;

use App\Events\AddChat;
use App\Http\Resources\ChatResource;
use App\Http\Resources\UserCheckRes;
use App\Http\Resources\UserResource;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public static function findUsersInChat(Chat $chat)
    {
        $users = ChatUser::where('chat_id', $chat->id)->get();
        return UserCheckRes::collection($users)->resolve();
    }

    private function inviteChat($user_id, $chat_id)
    {
        ChatUser::create([
            'user_id' => $user_id,
            'chat_id' => $chat_id
        ]);
    }

    public function createChatsssss() {
        $chat = Chat::create(['title' => 'und'])->id;
        return $chat;
    }

    public function createChat(User $user)
    {
        $curuser = auth()->user()->id;
        $chat_id = (DB::select("SELECT chat_users.chat_id FROM chat_users
            JOIN chats on chat_users.chat_id = chats.id
            WHERE user_id={$user->id}
            and chat_id in (SELECT chat_id FROM chat_users WHERE user_id={$curuser})
            and chats.is_publish=false"));
        if(empty($chat_id))
        {
            $chat_id = $this->createChat();
            $this->inviteChat($user->id, $chat_id);
            $this->inviteChat(Auth::user()->id, $chat_id);
            return redirect()->route('messages.index', ['chat' => $chat_id]);
        }
        return redirect()->route('messages.index', ['chat' => $chat_id[0]->chat_id]);
    }
    public function index(User $user)
    {
//        $this->createChat($user);
        $user = UserResource::make($user)->resolve();
        return inertia('User/Profile', compact('user'));
//        return redirect()->route('messages.index', ['user' => $users]);
    }
}
