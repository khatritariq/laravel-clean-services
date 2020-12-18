<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Services\User\CreateService;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *      path="v2/user",
     *      summary="Creates a new User",
     *      tags={"User"},
     *      description="Creates a new User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Post")
     *      ),
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function __invoke(CreateUserRequest $request, CreateService $service, Response $response)
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
