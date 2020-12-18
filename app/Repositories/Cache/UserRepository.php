<?php

namespace App\Repositories\Cache;

use App\Repositories\Cache\Contracts\UserRepositoryContract;

/**
 * Class UserRepository
 * @package App\\Repositories\Cache
 */

class UserRepository implements UserRepositoryContract
{
 
    public function set($key, $value, $expiry = null)
    {
       // set data in cache
    }

    public function get($key)
    {
        // get data from cache
    }
}
