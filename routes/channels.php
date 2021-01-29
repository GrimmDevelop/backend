<?php

/*
 * Authenticate the user's personal channel...
 */

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int)$user->id === (int)$userId;
});

Broadcast::channel('import.user.{userId}', function ($user, $userId) {
    return (int)$user->id === (int)$userId;
});

Broadcast::channel('window.{busId}', function ($user, $busId) {
    dd($user, $busId);
    return $busId === 1;
});
