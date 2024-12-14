<?php

namespace App\Services\RabbitMq;

use PhpAmqpLib\Message\AMQPMessage;
use App\Models\Article;
use App\Models\UserPreference;

class ArticlePublisher
{
    public function __construct(private readonly RabbitMqService $rabbitMqService) {}

    public function publishNewArticle(Article $article): void
    {
        UserPreference::where('areas_of_interest', $article->category)->chunk(100, function ($preferences) use ($article) {
            $preferences->each(function (UserPreference $preference) use ($article) {
                $message = json_encode([
                    'article_id' => $article->id,
                    'user_id' => $preference->user_id,
                ]);
                $this->rabbitMqService->publishMessage('article_recommendations', $message);
            });
        });
    }
}
