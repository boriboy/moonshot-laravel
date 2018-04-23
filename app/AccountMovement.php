<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountMovement extends Model
{
    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAW = 'withdraw';

    // ----- [relationships] ----- //

    /**
     * Eager load relationships
     * @var array
     */
    protected $with = ['user.balance'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
