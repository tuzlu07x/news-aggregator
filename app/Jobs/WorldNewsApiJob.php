<?php

namespace App\Jobs;

use App\Models\Article;
use App\News\WorldNewsApi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class WorldNewsApiJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $today = now()->format('Y-m-d');
        $worldNews = new WorldNewsApi();
        $worldNews->setCountry('us')
            ->setDate($today);

        $news = $worldNews->getNews();
        Article::upsert(
            $news['news'],
            ['title'],
            ['content', 'source', 'published_at', 'category', 'updated_at']
        );
    }
}
