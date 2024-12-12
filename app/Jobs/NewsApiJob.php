<?php

namespace App\Jobs;

use App\Enums\ArticleCategoryEnum;
use App\Models\Article;
use App\News\NewsApi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class NewsApiJob implements ShouldQueue
{
    use Queueable;
    private int $totalResults;
    private int $currentCategoryIndex = 0;

    public function __construct(public int $limit = 50, public int $page = 1) {}

    public function handle(): void
    {
        foreach (ArticleCategoryEnum::cases() as $category) {
            $label = $category->label();
            $news = $this->getNews($label);
            if (isset($news['message'])) Log::error($news['message']);
            Article::upsert(
                $news['news'],
                ['title'],
                ['content', 'source', 'published_at', 'category', 'updated_at']
            );
            if ($news['total_results'] > $this->limit * $this->page) {
                $this->dispatchNextPage();
            }
        }
    }

    private function getNews(string $category): array
    {
        $yesterday = now()->subDay()->format('Y-m-d');
        $today = now()->format('Y-m-d');

        $newsApi = new NewsApi();
        $data = $newsApi->setCategory($category)
            ->setCountry('us')
            ->setTo($today)
            ->setFrom($yesterday)
            ->getNews($this->limit, $this->page);

        $this->totalResults = $data['total_results'];

        return $data;
    }

    private function dispatchNextPage(): void
    {
        $nextPage = $this->page + 1;

        if ($this->limit * $nextPage <= $this->totalResults && $this->currentCategoryIndex < count(ArticleCategoryEnum::cases()) - 1) {
            $this->dispatch(new NewsApiJob($this->limit, $nextPage));
        }
    }

    private function moveToNextCategory(): void
    {
        $categories = ArticleCategoryEnum::cases();
        $this->currentCategoryIndex++;

        if ($this->currentCategoryIndex < count($categories)) {
            $this->dispatch(new NewsApiJob($this->limit, 1));
        }
    }
}
