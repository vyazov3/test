<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Http\Requests\Message\StoreRequest;
use Illuminate\Support\Facades\Auth;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index() {
        $messages = Message::latest()->get();
        $messages = MessageResource::collection($messages)->resolve();
        return inertia('Message/Index', compact('messages'));
    }
    public function store(StoreRequest $request) {
        $data = $request->validated();
        $message = Message::create($data);
        broadcast(new StoreMessageEvent($message))->toOthers();
        return MessageResource::make($message)->resolve();
    }
}
