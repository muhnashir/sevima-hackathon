<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('polls.{uuid}', function ($user, $uuid) {
    return true;
});
