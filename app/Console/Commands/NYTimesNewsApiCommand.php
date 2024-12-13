<?php

namespace App\Console\Commands;

use App\Jobs\NYTimesNewsApiJob;
use Illuminate\Console\Command;

class NYTimesNewsApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:nyTimesNewsApi';

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
        dispatch(new NYTimesNewsApiJob());
    }
}
