<?php

namespace App\Repositories\Eloquent;

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

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $userData): User
    {
        return $this->model->create($userData);
    }

    public function update(User $user, array $userData): bool
    {
        return $user->update($userData);
    }
}
