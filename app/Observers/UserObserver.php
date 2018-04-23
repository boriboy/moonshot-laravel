<?php

namespace App\Observers;

use App\User;

class UserObserver {

    /**
     * Listen to the User created event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user) {
        if ($user->role === User::ROLE_USER) {
            // create balances record for new users of role 'user'
            $user->balance()->create(['balance' => 0]);
        }
    }
}