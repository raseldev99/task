<?php

namespace App\Services\Auth;

use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
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
     * @return User
     */
    public function login(LoginRequest $request): User
    {
        //Authenticate the request
        $request->authenticate();
        return Auth::user();
    }

    /**
     * create a new user
     * @param array $userData
     * @return User
     */
    public function register(array $userData): User
    {
        return $this->userRepository->create($userData);
    }
}
