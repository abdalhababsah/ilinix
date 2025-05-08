<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
*/

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    return $user->conversations()->where('conversations.id', $conversationId)->exists();
});
// Private channel for user status updates
Broadcast::channel('user-status', function ($user) {
    // Only authenticated users can access
    return [
        'id' => $user->id,
        'name' => $user->full_name,
    ];
});