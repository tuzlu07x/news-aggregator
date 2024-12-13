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

    public function worldNewsApiClient(): ClientService
    {
        $client = new ClientService('X-Api-Key', 'https://api.worldnewsapi.com/', config('news.world_news_api_key'));
        return $client;
    }

    public function nyTimesApiClient(): ClientService
    {
        $client = new ClientService('api-key', 'https://api.nytimes.com/', config('news.ny_news_api_key'));
        return $client;
    }
}
