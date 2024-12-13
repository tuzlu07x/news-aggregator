<?php

namespace App\News;

use App\Enums\ArticleCategoryEnum;

class WorldNewsApi extends NewsAbstract
{
    private string $date;
    private string $country;

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getNews(int $limit = 1, int $page = 1): array
    {
        try {
            $response = $this->worldNewsApiClient();
            $articles = $response->get('top-news?language=en&source-country=' . $this->country . '&date=' . $this->date);
            dd($articles);
            if (!isset($articles['top_news'])) return [];
            $articles = array_reduce($articles['top_news'], function ($carry, $item) {
                return isset($item['news']) ? array_merge($carry, $item['news']) : $carry;
            }, []);
            $data = [
                'news' => array_map(fn($article) => $this->formatNews(
                    $this->resKeys(),
                    $article
                ), $articles),
            ];
            return $data;
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    protected static function resKeys(): array
    {
        return [
            'title' => 'title',
            'content' => 'text',
            'source' => 'source_country',
            'published_at' => 'publish_date',
            'category' => 'category',
            'author' => 'author',
        ];
    }
}
