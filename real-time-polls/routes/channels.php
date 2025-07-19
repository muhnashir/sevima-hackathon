<?php

use Illuminate\Support\Facades\Broadcast;

// Allow public access to the polls channel
Broadcast::channel('polls.{uuid}', function ($user = null, $uuid) {
    \Log::info('Channel authorization request', [
        'channel' => 'polls.'.$uuid,
        'user' => $user ? $user->id : 'public'
    ]);
    return true;
});
