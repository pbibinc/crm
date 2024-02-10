<?php

use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


// Broadcast::channel('calls', function ($user) {
//     return true;
// });

// Broadcast::routes();

// Or with authentication middleware
// Broadcast::routes(['middleware' => ['auth']]);
// Broadcast::channel('calls', function($user, $leadId){
//     return true;
// });