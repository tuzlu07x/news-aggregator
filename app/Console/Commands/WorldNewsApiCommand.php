<?php

namespace App\Console\Commands;

use App\Jobs\WorldNewsApiJob;
use Illuminate\Console\Command;

class WorldNewsApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:worldNewsApi';

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
        dispatch(new WorldNewsApiJob());
    }
}
