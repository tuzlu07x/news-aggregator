<?php

namespace App\Repositories\Article;

use App\Models\Article;
use Prettus\Repository\Eloquent\BaseRepository;

class ArticleRepository extends BaseRepository implements ArticleRepositoryImpl
{
    public function model(): string
    {
        return Article::class;
    }
}
