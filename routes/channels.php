<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('test', function () {
    return true;
});

/*
 * Authenticate the user's personal channel...
 */
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int)$user->id === (int)$userId;
});

Broadcast::channel('import.user.{userId}', function ($user, $userId) {
    return (int)$user->id === (int)$userId;
});
