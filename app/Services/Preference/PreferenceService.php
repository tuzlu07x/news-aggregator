<?php

namespace App\Services\Preference;

use App\Models\User;
use App\Models\UserPreference;
use App\Repositories\Preference\PreferenceRepositoryImpl;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class PreferenceService implements PreferenceServiceImpl
{
    public function __construct(private readonly PreferenceRepositoryImpl $repository) {}

    public function list(User $user, int $limit): LengthAwarePaginator
    {
        try {
            return $this->repository->paginateByUser($user, $limit);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create(int $userId, array $data): UserPreference
    {
        try {
            $data['user_id'] = $userId;
            return $this->repository->create($data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(int $userId, int $preferenceId, array $data): UserPreference
    {
        try {
            $preference = $this->repository->findWhere([
                'id' => $preferenceId,
                'user_id' => $userId,
            ])->first();

            if (!$preference) {
                throw new ModelNotFoundException('Preference not found.');
            }

            return $this->repository->update($data, $preferenceId);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(int $userId, int $preferenceId): bool
    {
        try {
            $preference = $this->repository->findWhere([
                'id' => $preferenceId,
                'user_id' => $userId,
            ])->first();

            if (!$preference) {
                throw new ModelNotFoundException('Preference not found.');
            }

            return (bool) $this->repository->delete($preferenceId);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
