<?php

namespace App\Events;

use App\Http\Resources\MessageResource;
use App\Http\Resources\MessageUserResource;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public object $message;
    public int $chat;
    /**
     * Create a new event instance.
     */
    public function __construct(object $message, int $chat)
    {
        $this->message = $message;
        $this->chat = $chat;

        //dd($message);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('store_message_' . $this->chat),
        ];
    }

    public function broadcastAs(): string
    {
        return 'store_message';
    }
    public function broadcastWith(): array
    {

        return [
            'message' => MessageUserResource::make($this->message)->resolve(),
        ];
    }
}
