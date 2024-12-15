<?php

namespace App\Services\Article;

use App\Models\Article;
use App\Repositories\Article\ArticleRepositoryImpl;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService implements ArticleServiceImpl
{
    public function __construct(private readonly ArticleRepositoryImpl $repository) {}

    public function list(int $limit): LengthAwarePaginator
    {
        return $this->repository->paginate($limit);
    }

    public function get(int $id): Article
    {
        return $this->repository->find($id);
    }
    public function create(array $data): Article
    {
        return $this->repository->create($data);
    }
    public function update(Article $article, array $data): Article
    {
        return $this->repository->update($data, $article->id);
    }
    public function delete(Article $article): bool
    {
        $article = $this->repository->delete($article->id);
        if ($article) return true;
        return false;
    }
}
