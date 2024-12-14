<?php

namespace App\Console\Commands;

use App\Jobs\RabbitMqConsumerJob;
use App\Jobs\RabbitMqPublisherJob;
use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RabbitMqPublisherAndConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitMQ:publisher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $today = now()->format('Y-m-d');
        $yesterday = now()->subDay()->format('Y-m-d');
        Cache::flush();
        Article::whereBetween('published_at', [$yesterday, $today])
            ->orderBy('published_at', 'desc')
            ->chunk(500, function ($articles) {
                $articles->each(function (Article $article) {
                    Cache::flush();

                    dispatch(new RabbitMqPublisherJob($article))->chain(
                        [new RabbitMqConsumerJob()]
                    );
                });
            });
    }
}
