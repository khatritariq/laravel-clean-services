<?php

namespace App\Http\Controllers;

use App\Helpers\CacheHelper;
use App\Helpers\MixpanelHelper;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *      path="v1/user",
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
    public function create(Request $request)
    {
        
        //1. Validate input
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subcription' => 'required',
        ]);

        if ($validated) {
            // Take input
            $input = $request->all();

            //2. Store user in database
            $user = new User();
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->subscription = $input['subscription'];
            $user->role = $input['role'];
            $saved = $user->save();

            //2. Store in cache
            if ($saved) {
                $oCacheHelper = new CacheHelper();
                $oCacheHelper->save('user_'.$user->id, $user->toArray());

                // Save user in mixpanel
                $oMixpanelHelper = new MixpanelHelper();
                $oMixpanelHelper->saveUser($user->toArray());
            }
            
            return $this->sendResponse($user->toArray(), 'User saved successfully');
        } else {
            return $this->sendResponse([], 'Error saving User');
        }
    }

    /**
    * @param Request $request
    * @return Response
    *
    * @SWG\Get(
    *      path="v1/user/{$id}",
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
    public function get(Request $request, $id)
    {
        //1. validate input
        $validated = $request->validate([
            'id' => 'integer'
        ]);

        if ($validated) {
            $oCacheHelper = new CacheHelper();
            $aUser = $oCacheHelper->get('user_'.$$id);

            if ($aUser) {
                return $this->sendResponse($aUser, 'User retrieved successfully');
            } else {
                $user = User::find($id);
                if ($user) {
                    return $this->sendResponse($user->toArray(), 'User retrieved successfully');
                }
            }
        }
        return $this->sendResponse([], 'User not found.');
    }
}