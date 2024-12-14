<?php

namespace App\Repositories\Recommendation;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Eloquent\BaseRepository;

class RecommendationRepository extends BaseRepository implements RecommendationRepositoryImpl
{
    public function model(): string
    {
        return Article::class;
    }
}
