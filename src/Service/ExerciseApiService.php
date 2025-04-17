<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExerciseApiService
{
    private HttpClientInterface $client;
    private string $apiKey;
    private string $apiHost;

    public function __construct(HttpClientInterface $client, string $apiKey, string $apiHost)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->apiHost = $apiHost;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getExerciseDetailsByName(string $exerciseName): array
    {
        $response = $this->client->request('GET', 'https://exercisedb.p.rapidapi.com/exercises/name/' . urlencode($exerciseName), [
            'headers' => [
                'x-rapidapi-key' => $this->apiKey,
                'x-rapidapi-host' => $this->apiHost,
            ]
        ]);

        return $response->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getAllExercises(): array
    {
        $response = $this->client->request('GET', 'https://exercisedb.p.rapidapi.com/exercises', [
            'headers' => [
                'x-rapidapi-key' => $this->apiKey,
                'x-rapidapi-host' => $this->apiHost,
            ],
            'query' => [
                'limit' => 0, // Request all data
            ],
        ]);

        return $response->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function searchExercisesByName(string $name, int $limit = 5): array
    {
        $response = $this->client->request(
            'GET',
            'https://exercisedb.p.rapidapi.com/exercises/name/'.urlencode($name),
            [
                'headers' => [
                    'x-rapidapi-key' => $this->apiKey,
                    'x-rapidapi-host' => $this->apiHost,
                ],
                'query' => ['limit' => $limit]
            ]
        );

        return $response->toArray();
    }
}