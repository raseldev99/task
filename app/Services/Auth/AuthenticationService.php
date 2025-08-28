<?php

namespace App\Services\Auth;

use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Traits\ApiResponse;
use Auth;
use Illuminate\Http\JsonResponse;

class AuthenticationService
{
    use ApiResponse;


    public UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository){
        $this->userRepository = $userRepository;
    }

    /**
     * Handle user login
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        //Authenticate the request
        $request->authenticate();
        $user = Auth::user();
        return $this->success('Login Successful',[
            'user' => new UserResource($user),
            'token' => [
                'token_type' => 'Bearer',
                'token' => $user->createToken('AuthToken')->plainTextToken,
            ]
        ]);
    }

    /**
     * create a new user
     * @param array $userData
     * @return JsonResponse
     */
    public function register(array $userData): JsonResponse
    {
        // Create user
        $user = $this->userRepository->create($userData);

        return $this->ok('Register Successful');
    }
}
