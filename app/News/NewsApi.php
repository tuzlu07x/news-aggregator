<?php

namespace App\News;

use App\Enums\ArticleCategoryEnum;

class NewsApi extends NewsAbstract
{
    private string $from;
    private string $to;
    private string $country;
    private string $category;

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }


    private function stringToIntOfCategory(): int
    {
        return ArticleCategoryEnum::stringToInt($this->category);
    }

    public function setFrom(string $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function setTo(string $to): self
    {
        $this->to = $to;
        return $this;
    }

    public function getNews(int $limit, int $page): array
    {
        try {
            $response = $this->newsApiClient($this->country, $this->category);
            $articles = $response->get('top-headlines?category=' . $this->category . '&country=' . $this->country . '&pageSize=' . $limit . '&page=' . $page . '&from=' . $this->from . '&to=' . $this->to);
            $data = [
                'total_results' => $articles['totalResults'] ?? 1,
                'news' => array_map(fn($article) => $this->formatNews(
                    $this->resKeys(),
                    array_merge($article, ['category' => $this->stringToIntOfCategory()])
                ), $articles['articles']),
            ];
            return $data;
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private static function resKeys(): array
    {
        return [
            'title' => 'title',
            'content' => 'content',
            'source' => function ($news) {
                return $news['source']['name'] ?? null;
            },
            'published_at' => 'publishedAt',
            'category' => 'category',
        ];
    }
}
