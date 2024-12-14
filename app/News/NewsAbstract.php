<?php

namespace App\News;

use App\Traits\ClientTrait;
use Carbon\Carbon;

abstract class NewsAbstract
{
    use ClientTrait;
    abstract public function getNews(int $limit, int $page): array;
    abstract protected static function resKeys(): array;

    public function formatNews(array $keys, array $news): array
    {
        return [
            'title' => $news[$keys['title']],
            'content' => $news[$keys['content']],
            'source' => is_callable($keys['source']) ? $keys['source']($news) : $news[$keys['source']],
            'published_at' => Carbon::parse($news[$keys['published_at']])->format('Y-m-d H:i:s'),
            'category' => $news[$keys['category']] ?? 'unknown',
            'author' => is_callable($keys['author']) ? $keys['author']($news) : $news[$keys['author']],
        ];
    }
}
