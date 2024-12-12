<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\AuthRepositoryImpl;

class AuthService implements AuthServiceImpl
{
    public function __construct(private readonly AuthRepositoryImpl $repository) {}

    public function getUserByEmail(array $data): ?User
    {
        return $this->repository->findWhere(['email' => $data['email']])->first();
    }

    public function createUser(array $data): User
    {
        return $this->repository->create($data);
    }

    public function deleteUserToken(User $user): void
    {
        $this->repository->deleteToken($user);
    }
}
