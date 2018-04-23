<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /** constants section */
    const TYPE_USER = 'user';
    const TYPE_AGENT = 'agent';

    const ROLE_USER = 'user';
    const ROLE_REP = 'rep';
    const ROLE_ADMIN = 'admin';

    /**
     * Eager load relationships
     * @var array
     */
    protected $with = ['balance'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'login_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Sets login_at column to last login time
     *
     * @return bool
     */
    public function bumpLastLogin(){
        $this->login_at = Carbon::now();

        return $this->save();
    }

    /**
     * Returns user type (user/agent)
     * @return string
     */
    public function type() {
        return $this->role === self::ROLE_USER ? self::TYPE_USER : self::TYPE_AGENT;
    }

    // ----- [static] ----- //

    /**
     * Returns default role per type(user/agent)
     * this function is necessary since "agent" is not an official role recorded in the database
     *
     * @param false|string $type may be one of: user/agent
     * @return string
     */
    public static function resolveDefaultRoleForType($type = false) {
        return $type === self::TYPE_AGENT ? self::ROLE_REP : self::ROLE_USER;
    }

    // ----- [relationships] ----- //

    /**
     * User has one balance
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function balance() {
        return $this->hasOne(Balance::class);
    }

    /**
     * Movements in user's account
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accountMovements() {
        return $this->hasMany(AccountMovement::class);
    }
}
