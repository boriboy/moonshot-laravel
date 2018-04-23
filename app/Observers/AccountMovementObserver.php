<?php

namespace App\Observers;

use App\AccountMovement;

class AccountMovementObserver {

    /**
     * Listen to the AccountMovement created event.
     *
     * @param  \App\AccountMovement  $user
     * @return void
     */
    public function created(AccountMovement $accountMovement) {
        // get balance
        $balance = $accountMovement->user->balance;

        // change balance amount according to movement
        if ($accountMovement->type === AccountMovement::TYPE_DEPOSIT) {
            $balance->balance += $accountMovement->amount;
        } elseif ($accountMovement->type === AccountMovement::TYPE_WITHDRAW) {
            $balance->balance -= $accountMovement->amount;
        }

        // commit changes to db
        $balance->save();
    }
}