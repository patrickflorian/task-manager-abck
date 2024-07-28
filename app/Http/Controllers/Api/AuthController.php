<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\DetailedUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{
    /**
     * Registers a new user.
     *
     * @param RegisterRequest $request The request object containing the user's information.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the user and token.
     */
    public function register(RegisterRequest $request)
    {
        $fields = $request->validated();
        DB::beginTransaction();
        try{
            $user = User::create([
                'username' => $fields['name'],
                'email' => $fields['email'],
                'password' => $fields['password'],
            ]);

            $token = $user->createToken('taskmanager')->plainTextToken;
            $user = DetailedUserResource::make($user);
            DB::commit();

            return $this->sendSuccessResponse(compact('user', 'token'),'User successfully created', Response::HTTP_CREATED);
        }catch(\Throwable $th){
            DB::rollBack();
            Log::error($th);
        }
        return $this->sendErrorResponse(message: 'Something went wrong',status: Response::HTTP_INTERNAL_SERVER_ERROR);

    }

    /**
     * Logs in a user with the provided email and password.
     *
     * @param Request $request The HTTP request object containing the email and password.
     * @return JsonResponse The JSON response containing the user and token if the login is successful, or an error message if the credentials are invalid.
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
           'email' => ['required', 'email'],
           'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !$user->isValidPassword($fields['password'])) {
            return $this->sendErrorResponse(message: 'Bad Credentials');
        }

        $token = $user->createToken('taskmanager')->plainTextToken;
        $user = DetailedUserResource::make($user);

        return $this->sendSuccessResponse(compact('user', 'token'), 'User successfully logged in', Response::HTTP_OK);
    }

    /**
     * Logs out the authenticated user by deleting their current access token.
     *
     * @param Request $request The HTTP request object.
     * @return JsonResponse The JSON response indicating the success of the logout.
     */
    public function logout(Request $request)
    {
        auth()->user()->currentAccessToken()->delete();


        return $this->sendSuccessResponse(message: 'User successfully logged out from this device');
    }

}
