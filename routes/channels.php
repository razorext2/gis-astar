<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('exportFiles.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
