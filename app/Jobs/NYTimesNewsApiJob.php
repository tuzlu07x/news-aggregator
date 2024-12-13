<?php

namespace App\Jobs;

use App\Models\Article;
use App\News\NYTimesNewsApi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NYTimesNewsApiJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $page = 1)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $nyApi = new NYTimesNewsApi();
        $nyApi->setCountry('US')
            ->setBeginDate(now()->subDay()->format('Ymd'))
            ->setEndDate(now()->format('Ymd'));

        $news = $nyApi->getNews(limit: 10, page: $this->page);
        if (empty($news['news'])) return;

        Article::upsert(
            $news['news'],
            ['title'],
            ['content', 'source', 'published_at', 'category', 'updated_at']
        );

        $meta = $news['meta'];
        $totalPages = ceil($meta['hits'] / 10);

        if ($this->page < $totalPages) {
            dispatch(new NYTimesNewsApiJob($this->page + 1));
        }
    }
}
