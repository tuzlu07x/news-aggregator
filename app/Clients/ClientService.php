<?php

namespace App\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ClientService
{
    private string $baseUri;
    private string $accessToken;
    private ?Client $client = null;

    public function __construct(string $tokenKey, string $baseUri, string $accessToken)
    {
        $this->baseUri = $baseUri;
        $this->accessToken = $accessToken;
        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                $tokenKey =>  $this->accessToken,
            ]
        ]);
    }

    private function request(string $method, string $uri, array $options): mixed
    {
        try {
            $response = $this->client->request($method, $uri, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function post(string $uri, array $options = []): ?array
    {
        return $this->request('POST', $uri, $options);
    }

    public function get(string $uri, array $options = []): array
    {
        return $this->request('GET', $uri, $options);
    }

    public function put(string $uri, array $options): ?array
    {
        return $this->request('PUT', $uri, $options);
    }

    public function delete(string $uri, array $options = []): mixed
    {
        return $this->request('DELETE', $uri, $options);
    }
}
