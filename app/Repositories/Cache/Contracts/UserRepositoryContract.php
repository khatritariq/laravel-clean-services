<?php

namespace App\Repositories\Cache\Contracts;

use App\Models\User;

interface UserRepositoryContract
{
    public function set($key, $value, $expiry = null);

    public function get($key);
}
