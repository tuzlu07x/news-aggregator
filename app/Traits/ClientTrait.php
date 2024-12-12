<?php

namespace App\Traits;

use App\Clients\ClientService;

trait ClientTrait
{
    public function newsApiClient(): ClientService
    {
        $client = new ClientService('X-Api-Key', 'https://newsapi.org/v2/', config('news.news_api_key'));
        return $client;
    }
}
