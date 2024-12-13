<?php

namespace App\News;

class NYTimesNewsApi extends NewsAbstract
{
    private string $country;
    private string $beginDate;
    private string $endDate;

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function setBeginDate(string $beginDate): self
    {
        $this->beginDate = $beginDate;
        return $this;
    }

    public function setEndDate(string $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getNews(int $limit = 1, int $page = 1): array
    {
        try {
            $response = $this->nyTimesApiClient();
            $articles = $response->get('svc/search/v2/articlesearch.json?begin_date=' .
                $this->beginDate . '&end_date=' . $this->endDate . '&facet=true&facet_fields=section_name&facet_filter=true&fq=' . $this->country . '&page=' . $page . '&sort=newest&api-key=' . config('news.ny_news_api_key'));
            if (!isset($articles['response']['docs'])) return [];
            $data = [
                'meta' => $articles['response']['meta'],
                'news' => array_map(fn($article) => $this->formatNews(
                    $this->resKeys(),
                    $article
                ), $articles['response']['docs']),
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
            'title' => 'abstract',
            'content' => 'lead_paragraph',
            'source' => 'source',
            'published_at' => 'pub_date',
            'category' => 'section_name',
            'author' => function ($news) {
                return ltrim($news['byline']['original'], 'By ') ?? null;
            },
        ];
    }
}
