<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'balance'
    ];

    public function initiateOperation(User $user, $amount, string $type) {
        // todo: should be a db transaction to allow multiple actions simultaneously
        // validate deposit/withdraw
        if (!in_array($type, [AccountMovement::TYPE_WITHDRAW, AccountMovement::TYPE_DEPOSIT])) {
            throw new \Exception('invalid account movement type: ' . $type);
        }

        // user tries to withdraw more than he has, raise exception
        if ($type === AccountMovement::TYPE_WITHDRAW && ($amount > $this->balance)) {
            throw new \Exception('can\'t withdraw ' . $amount . ' from balance ' . $this->balance);
        }

        // create account movement (balance will update in model observer)
        $user->accountMovements()->create(['amount' => $amount, 'type' => $type]);
    }
}
