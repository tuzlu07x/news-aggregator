<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\Article\ArticleServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleServiceImpl $articleService) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $articles = $this->articleService->list($request->input('limit', 10));
        return ArticleResource::collection($articles);
    }

    public function store(ArticleRequest $request): ArticleResource
    {
        $article = $this->articleService->create($request->validated());
        return ArticleResource::make($article);
    }

    public function show(Article $article): ArticleResource
    {
        $article = $this->articleService->get($article->id);
        return ArticleResource::make($article);
    }

    public function update(ArticleRequest $request, Article $article): ArticleResource
    {
        $article = $this->articleService->update($article, $request->validated());
        return ArticleResource::make($article);
    }

    public function destroy(Article $article): \Illuminate\Http\JsonResponse
    {
        $isDeleted = $this->articleService->delete($article);
        if ($isDeleted) return response()->json(['message' => 'Article deleted successfully'], 200);
        return response()->json(['message' => 'Article not found'], 404);
    }
}
