<?php

namespace App\Repositories\User;

use App\Models\User;
use Prettus\Repository\Contracts\RepositoryInterface;

interface AuthRepositoryImpl extends RepositoryInterface
{
    public function deleteToken(User $user): void;
}
