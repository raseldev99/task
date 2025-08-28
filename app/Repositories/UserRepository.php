<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{

    /**
     * The User model instance.
     */
    protected User $model;

    /**
     * UserRepository constructor.
     *
     * @param  User  $model  The User model instance to work with.
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return $this->model->find($id);
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * @param array $userData
     * @return User
     */
    public function create(array $userData): User
    {
       return $this->model->create($userData);
    }

    /**
     * @param User $user
     * @param array $userData
     * @return bool
     */
    public function update(User $user, array $userData): bool
    {
       return $user->update($userData);
    }
}
