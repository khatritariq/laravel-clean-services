<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetUserRequest;
use App\Services\User\GetService;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class GetController extends Controller
{
    /**
    * @param Request $request
    * @return Response
    *
    * @SWG\Get(
    *      path="v2/user/{$id}",
    *      summary="Get list of users",
    *      tags={"User"},
    *      description="Get all users",
    *      produces={"application/json"},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *          @SWG\Schema(
    *              type="object",
    *              @SWG\Property(
    *                  property="success",
    *                  type="boolean"
    *              ),
    *              @SWG\Property(
    *                  property="data",
    *                  type="array",
    *                  @SWG\Items(ref="#/definitions/User")
    *              ),
    *              @SWG\Property(
    *                  property="message",
    *                  type="string"
    *              )
    *          )
    *      )
    * )
    */
    public function __invoke(GetUserRequest $request, GetService $service, Response $response)
    {
        
        try {
            $validated = $request->validate();

            if ($validated) {
                $response = $service($request, $response);
            }
        } catch (Exception $e) {
            // send error response
        }
        return $this->sendResponse($response);
    }
}
