<?php

namespace App\Jobs;

use App\Services\RabbitMq\ArticleConsumer;
use App\Services\RabbitMq\RabbitMqService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class RabbitMqConsumerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;
    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $rabbitmqService = new RabbitMqService();
        $consumer = new ArticleConsumer($rabbitmqService);
        $consumer->consumeNewArticleMessages();
    }
}
