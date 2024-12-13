<?php

namespace App\Services\Preference;

use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Pagination\LengthAwarePaginator;

interface PreferenceServiceImpl
{
    public function list(User $user, int $limit): LengthAwarePaginator;
    public function create(int $userId, array $data): UserPreference;
    public function update(int $userId, int $preferenceId, array $data): UserPreference;
    public function delete(int $userId, int $preferenceId): bool;
}
