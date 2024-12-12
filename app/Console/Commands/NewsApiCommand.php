<?php

namespace App\Console\Commands;

use App\Enums\ArticleCategoryEnum;
use App\Jobs\NewsApiJob;
use App\News\NewsApi;
use Illuminate\Console\Command;

class NewsApiCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:newsApi';

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
        dispatch(new NewsApiJob());
    }
}
