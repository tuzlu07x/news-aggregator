<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ClientService
{
    private string $baseUri;
    private ?string $storeHash = null;
    private string $accessToken;
    private ?Client $client = null;

    public function __construct(string $tokenName, string $baseUri, string $accessToken)
    {
        $this->baseUri = $baseUri;
        $this->accessToken = $accessToken;
        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                $tokenName =>  $this->accessToken,
            ]
        ]);
    }

    public function setStoreHash(string $storeHash): self
    {
        $this->storeHash = $storeHash;
        return $this;
    }

    private function storeHassedUri(string $uri): string
    {
        return $this->storeHash . '/' . $uri;
    }

    private function request(string $method, string $uri, array $options): mixed
    {
        $manipulatedUri = null === $this->storeHash ? $uri : $this->storeHassedUri($uri);
        try {
            $response = $this->client->request($method, $manipulatedUri, $options);
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
