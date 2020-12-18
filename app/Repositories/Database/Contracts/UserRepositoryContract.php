<?php

namespace App\Repositories\Database\Contracts;

use App\Models\User;

interface UserRepositoryContract
{
    public function save($user): User;
    public function get(int $user);
}
