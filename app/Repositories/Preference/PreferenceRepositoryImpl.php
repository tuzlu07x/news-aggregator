<?php

namespace App\Repositories\Preference;

use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

interface PreferenceRepositoryImpl extends RepositoryInterface
{
    public function paginateByUser(User $user, int $limit): LengthAwarePaginator;
}
