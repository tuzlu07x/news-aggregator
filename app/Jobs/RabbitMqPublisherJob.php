<?php

namespace App\Jobs;

use App\Models\Article;
use App\Services\RabbitMq\ArticlePublisher;
use App\Services\RabbitMq\RabbitMqService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class RabbitMqPublisherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;
    public ArticlePublisher $publisher;
    /**
     * Create a new job instance.
     */
    public function __construct(public Article $article) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $rabbitmqService = new RabbitMqService();
        $publisher = new ArticlePublisher($rabbitmqService);
        $publisher->publishNewArticle($this->article);
    }
}
