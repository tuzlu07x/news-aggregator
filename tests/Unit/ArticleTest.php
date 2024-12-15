<?php

use Mockery;
use App\Models\Article;
use App\Services\Article\ArticleServiceImpl;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class)->group('articles');

beforeEach(function () {
    $this->mockArticleService = Mockery::mock(ArticleServiceImpl::class);
    app()->instance(ArticleServiceImpl::class, $this->mockArticleService);
});

it('can list articles', function () {
    $articlesCollection = collect([
        ['id' => 1, 'title' => 'Article 1'],
        ['id' => 2, 'title' => 'Article 2'],
    ]);

    $paginator = Mockery::mock(LengthAwarePaginator::class);
    $paginator->shouldReceive('count')->andReturn($articlesCollection->count());
    $paginator->shouldReceive('items')->andReturn($articlesCollection->all());

    $this->mockArticleService->shouldReceive('list')
        ->once()
        ->with(10)
        ->andReturn($paginator);

    $articles = $this->mockArticleService->list(10);

    expect($articles->count())->toBe(2);
});

it('can create an article', function () {

    $data = [
        'title' => 'Test News1',
        'content' => 'Test Content.',
        'category' => 'technology',
        'author' => 'Jane Doe',
        'source' => 'Fatih',
        'published_at' => '2024-12-14 04:11:00',
    ];

    $this->mockArticleService->shouldReceive('create')
        ->once()
        ->with($data)
        ->andReturn(new Article($data));

    $article = $this->mockArticleService->create($data);

    expect($article->title)->toBe('Test News1');
});

it('can update an article', function () {
    $article = new Article([
        'id' => 1,
        'title' => 'Test News1',
        'content' => 'Test Content.',
        'category' => 'technology',
        'author' => 'Jane Doe',
        'source' => 'Fatih',
        'published_at' => '2024-12-14 04:11:00',
    ]);
    $article->save();

    $data = [
        'title' => 'Test News by Fatih',
        'content' => 'Test Content.',
        'category' => 'technology',
        'author' => 'Jane Doe',
        'source' => 'Fatih',
        'published_at' => '2024-12-14 04:11:00',
    ];

    $this->mockArticleService->shouldReceive('update')
        ->once()
        ->with($article, $data)
        ->andReturn(tap($article, function ($article) use ($data) {
            $article->title = $data['title'];
        }));

    $updatedArticle = $this->mockArticleService->update($article, $data);
    expect($updatedArticle->title)->toBe('Test News by Fatih');
});


it('can delete an article', function () {
    $article = new Article([
        'id' => 1,
        'title' => 'Test News1',
        'content' => 'Test Content.',
        'category' => 'technology',
        'author' => 'Jane Doe',
        'source' => 'Fatih',
        'published_at' => '2024-12-14 04:11:00',
    ]);
    $article->save();

    $this->mockArticleService->shouldReceive('delete')
        ->once()
        ->with($article)
        ->andReturn(true);

    $deletedArticle = $this->mockArticleService->delete($article);
    expect($deletedArticle)->toBeTrue();
});
