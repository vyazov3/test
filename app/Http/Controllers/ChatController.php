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
        ChatUser::create(['user_id' => $user_id, 'chat_id' => $chat_id]);
    }

    public function createChatsssss() {
        $chat = Chat::create(['title' => 'myChat','is_publish' => false,])->id;
        return $chat;
    }

    public function addChat(User $user)
    {

        // $new = ChatUser::where('user_id', $user->id)->get();
        // $cur = ChatUser::where('user_id', Auth::user()->id)->get();

        $user_new = ChatUser::where(['user_id'=> $user->id])->get();
        $user_cur = ChatUser::where(['user_id'=> auth()->user()->id])->get();


        $collection = $user_new->merge($user_cur);

        $chatExists = $collection->groupBy('chat_id')->where(function($chats){

            $exists = $chats->where(function($z){
                return $z->chat->is_publish === false;
            })->isNotEmpty();

            return $exists;

        });

        dd($chatExists);

        if($chatExists->isEmpty())
        {
            $chat_id = $this->createChatsssss();
            $this->inviteChat($user->id, $chat_id);
            $this->inviteChat(Auth::user()->id, $chat_id);
            return redirect()->route('messages.index', ['chat' => $chat_id]);
        } else {
            return redirect()->route('messages.index', ['chat' => $chatExists->first()->first()->chat->id]);
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
