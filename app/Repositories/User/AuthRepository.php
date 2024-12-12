<?php

namespace App\Repositories\User;

use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

class AuthRepository extends BaseRepository implements AuthRepositoryImpl
{
    public function model()
    {
        return User::class;
    }

    public function deleteToken(User $user): void
    {
        $user->tokens()->delete();
    }
}
