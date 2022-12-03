<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\UserContract;
use App\Models\User;

/**
 * Class UserRepository
 */
class UserRepository extends Repository implements UserContract
{
    /**
     * UserRepository constructor.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
