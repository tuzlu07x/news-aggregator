<?php

namespace App\Services\User;

use App\Models\User;

interface AuthServiceImpl
{
    public function getUserByEmail(array $data): ?User;
    public function createUser(array $data): User;
    public function deleteUserToken(User $user): void;
}
