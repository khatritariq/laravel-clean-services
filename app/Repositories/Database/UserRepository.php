<?php

namespace App\Repositories\Database;

use App\Models\User;
use App\Repositories\Database\Contracts\UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    public function save($user) : User
    {
        // saves User in database
        return new User;
    }

    public function get(int $id) : User
    {
        return User::find($id);
    }
}
