<?php

use App\Http\Controllers\ChatController;
use App\Models\Chat;
use Illuminate\Support\Facades\Broadcast;
use mysql_xdevapi\Collection;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id){
    return (int) $user->id === (int) $id;
});

Broadcast::channel('store_message_{chat_id}', function ($user, $chat_id) {
    return collect(ChatController::findUsersInChat(Chat::find($chat_id)))->contains('user_id', $user->id);
});
