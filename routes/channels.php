<?php

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('mc-chat-conversation.{conversation_id}', function($user, $conversation_id) {
    return $user;
});

Broadcast::channel('conversation.{conversation_id}.{user_id}', function($user, $conversation_id, $user_id) {
    return $user;
});
