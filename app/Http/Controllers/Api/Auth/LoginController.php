<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthenticationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends Controller
{
    use ApiResponse;
    public AuthenticationService $authenticationService;
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * handle login request
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user =  $this->authenticationService->login($request);

       return $this->success('Login Successful',[
            'user' => new UserResource($user),
            'token' => [
                'token_type' => 'Bearer',
                'token' => $user->createToken('AuthToken')->plainTextToken,
            ]
        ]);
    }
}
