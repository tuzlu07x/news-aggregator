<?php

namespace App\News;

use App\Traits\ClientTrait;
use Carbon\Carbon;

abstract class NewsAbstract
{
    use ClientTrait;
    abstract public function getNews(int $limit, int $page): array;

    public function formatNews(array $keys, array $news): array
    {
        return [
            'title' => $news[$keys['title']],
            'content' => $news[$keys['content']],
            'source' => is_callable($keys['source']) ? $keys['source']($news) : $news[$keys['source']],
            'published_at' => Carbon::parse($news['publishedAt'])->format('Y-m-d H:i:s'),
            'category' => $news[$keys['category']],
            'author' => $news['author'],
        ];
    }
}
