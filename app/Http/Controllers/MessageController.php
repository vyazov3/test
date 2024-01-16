<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\MessageUserResource;
use App\Http\Resources\UserResource;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public static function checkUser($chat_id)
    {
        return collect(ChatController::findUsersInChat($chat_id))->contains('user_id', Auth::user()->id);
    }
    public function index(Chat $chat) {
        if (MessageController::checkUser($chat)) {
            $messages = Message::where('chat_id', $chat->id)->get();
            foreach ($messages as $message) {
                $message['name'] = $message->user->name;
            }
            $messages = MessageUserResource::collection($messages)->resolve();
            $chat_name = $chat->title;
            return inertia('Message/Index', compact('messages', 'chat_name'));
        }
        return redirect()->route('dashbord');
    }
    public function store(Chat $chat, StoreRequest $request) {
        $data = $request->validated();
        $message = Message::create($data);

        //$message->append('name',$message->user->name);

        $message->setAttribute('name','blabla');

        broadcast(new StoreMessageEvent($message, $chat->id))->toOthers();

        return MessageUserResource::make($message)->resolve();
    }
}
