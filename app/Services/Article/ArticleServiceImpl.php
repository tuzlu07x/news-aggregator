<?php

namespace App\Services\Article;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleServiceImpl
{
    public function list(int $limit): LengthAwarePaginator;
    public function create(array $data): Article;
    public function get(int $id): Article;
    public function update(Article $article, array $data): Article;
    public function delete(Article $article): bool;
}
