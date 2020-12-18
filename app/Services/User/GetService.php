<?php

namespace App\Services\User;

use App\Http\Requests\GetUserRequest;
use App\Repositories\Cache\UserRepository as CacheUserRepository;
use App\Repositories\Database\UserRepository;
use GuzzleHttp\Psr7\Response;
use stdClass;

/**
 * Class GetService
 * @package App\Services\User
 * Service that gets a User
 */
class GetService
{
    public UserRepository $oDbUserRepository ;
    public CacheUserRepository $oCacheUserRepository;

    public function __construct(
        UserRepository $oDbUserRepository,
        CacheUserRepository $oCacheUserRepository
    ) {
        $this->oDbUserRepository = $oDbUserRepository;
        $this->oCacheUserRepository = $oCacheUserRepository;
    }

    public function __invoke(GetUserRequest $input, Response $response)
    {
        try {
            $userKey = sprintf(Constants::KEY_USER, $input->id);

            $oUser = $this->oCacheUserRepository->get($userKey);

            if ($oUser->isEmpty()) {
                $oUser = $this->oDbUserRepository->get($input->id);

                if ($oUser->isEmpty()) {
                     $response->set(new stdClass);
                }
            }
            $response->set($oUser);
        } catch (\Exception $e) {
            $response->set(oUser);
        } finally {
            return $response;
        }
    }
}