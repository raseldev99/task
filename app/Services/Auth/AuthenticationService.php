<?php

namespace App\Services\Auth;

use App\Http\Requests\API\Auth\LoginRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\ApiResponse;
use Auth;

class AuthenticationService
{
    use ApiResponse;

    public UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle user login
     */
    public function login(LoginRequest $request): User
    {
        // Authenticate the request
        $request->authenticate();

        return Auth::user();
    }

    /**
     * create a new user
     */
    public function register(array $userData): User
    {
        return $this->userRepository->create($userData);
    }
}
