<?php

namespace App\Services\RabbitMq;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ArticleConsumer
{

    public function __construct(private RabbitMqService $rabbitMqService)
    {
        $this->rabbitMqService = $rabbitMqService;
    }

    public function consumeNewArticleMessages(): void
    {
        $this->rabbitMqService->consumeMessages('article_recommendations', function ($msg) {
            $data = json_decode($msg->body, true);
            $article = Article::select('id')->find($data['article_id']);
            if (!$article) {
                return;
            }

            $user = User::find($data['user_id']);
            if ($user) {
                $cacheKey = "user_{$user->id}_recommendations";
                $cacheData = Cache::get($cacheKey, []);
                if (!in_array($article->id, array_column($cacheData, 'id'))) {
                    $cacheData[] = $article;
                    Cache::put($cacheKey, $cacheData, now()->addHours(1));
                }
            }
        });
    }
}
