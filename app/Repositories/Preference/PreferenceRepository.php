<?php

namespace App\Repositories\Preference;

use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Eloquent\BaseRepository;

class PreferenceRepository extends BaseRepository implements PreferenceRepositoryImpl
{
    public function model()
    {
        return UserPreference::class;
    }

    public function paginateByUser(User $user, int $limit): LengthAwarePaginator
    {
        return $user->preferences()->paginate($limit);
    }
}
