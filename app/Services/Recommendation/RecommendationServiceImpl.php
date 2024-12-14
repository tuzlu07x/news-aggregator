<?php

namespace App\Services\Recommendation;

use Illuminate\Pagination\LengthAwarePaginator;

interface RecommendationServiceImpl
{
    public function recommend(int $userId, int $limit): LengthAwarePaginator;
}
