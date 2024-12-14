<?php

namespace App\Services\Recommendation;

use App\Repositories\Recommendation\RecommendationRepositoryImpl;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class RecommendationService implements RecommendationServiceImpl
{
    public function __construct(private readonly RecommendationRepositoryImpl $repository) {}

    public function recommend(int $userId, int $limit): LengthAwarePaginator
    {
        // Retrieve cached recommendations
        $articleIds = collect(Cache::get("user_{$userId}_recommendations", []))
            ->pluck('id') // Extract only the `id` values from the array
            ->toArray();
        if (empty($articleIds)) {
            throw new \Exception('No recommendations found');
        }
        return $this->repository
            ->scopeQuery(function ($query) use ($articleIds) {
                return $query->whereIn('id', $articleIds);
            })
            ->paginate($limit);
    }
}
