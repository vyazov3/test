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
    public function index(Chat $chat) {
        $messages = Message::where('chat_id', $chat->id)->latest()->get();
        foreach ($messages as $message) {
            $message['name'] = $message->user->name;
        }
        $messages = MessageUserResource::collection($messages)->resolve();
        $chat_name = $chat->title;

        return inertia('Message/Index', compact('messages', 'chat_name'));
    }
    public function store(Chat $chat, StoreRequest $request) {
        $data = $request->validated();
        $message = Message::create($data);
        $message['name'] =  $message->user->name;
        broadcast(new StoreMessageEvent($message, $chat->id))->toOthers();
        return MessageUserResource::make($message)->resolve();
    }
}
