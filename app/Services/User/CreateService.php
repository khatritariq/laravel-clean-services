<?php

namespace App\Services\User;

use App\Http\Requests\CreateUserRequest;
use App\Repositories\Cache\UserRepository as CacheUserRepository;
use App\Repositories\Database\UserRepository;
use App\Repositories\External\Telemetry\Contracts\TelemetryContract;
use GuzzleHttp\Psr7\Response;

/**
 * Class CreateService
 * @package App\Services\User
 * Service that creates a User
 */
class CreateService
{
    public UserRepository $oDbUserRepository ;
    public CacheUserRepository $oCacheUserRepository;
    public TelemetryContract $oTelemetryRepository;

    public function __construct(
        UserRepository $oDbUserRepository,
        CacheUserRepository $oCacheUserRepository,
        TelemetryContract $oTelemetryRepository
    ) {
        $this->oDbUserRepository = $oDbUserRepository;
        $this->oCacheUserRepository = $oCacheUserRepository;
        $this->oTelemetryRepository = $oTelemetryRepository;
    }

    public function __invoke(CreateUserRequest $input, Response $response)
    {
        try {
            $oDbUser = $this->oDbUserRepository->save($input->toArray());

            if (!$oDbUser->isEmpty()) {
                $userKey = sprintf(Constants::KEY_USER, $oDbUser->id);
                $this->oCacheUserRepository->set($userKey, $input->toArray());
                
                $this->oTelemetryRepository->saveUser($input->toArray());
            }
            $response->set(1);
        } catch (\Exception $e) {
            $response->set(0);
        } finally {
            return $response;
        }
    }
}