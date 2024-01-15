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

    public function createChatsssss() {
        $chat = Chat::create(['title' => 'und'])->id;
        return $chat;
    }

    public function createChat(User $user)
    {

        $new = ChatUser::where('user_id', $user->id)->get();
        $cur = ChatUser::where('user_id', Auth::user()->id)->get();
        $hlp = false;
        $merg = $new->merge($cur)->groupBy('chat_id');
        foreach ($merg as $value) {
            if ($value->count() >= 2) {
                dump('чат существует');
                $hlp = true;
                $chat_id = $value[0]['chat_id'];
            }
        }
        if (!$hlp) {
            dump('нет чата, создаем');
            $chat_id = $this->createChatsssss();
            $this->inviteChat($user->id, $chat_id);
            $this->inviteChat(Auth::user()->id, $chat_id);
            return redirect()->route('messages.index', ['chat' => $chat_id]);
        } else {
            return redirect()->route('messages.index', ['chat' => $chat_id]);
        }
    }
    public function index(User $user)
    {
//        $this->createChat($user);
        $user = UserResource::make($user)->resolve();
        return inertia('User/Profile', compact('user'));
//        return redirect()->route('messages.index', ['user' => $users]);
    }
}
