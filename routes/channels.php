<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Canale pubblico - non serve autorizzazione
Broadcast::channel('admin-notifications', function ($user) {
     return  $user->hasRole('amministratore');
});