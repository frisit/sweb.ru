<?php

namespace App\Service\Api;

use GuzzleHttp\ClientInterface;

class ApiClient
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $baseApiUrl;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * ApiClient constructor.
     * @param ClientInterface $client
     * @param string $apiKey
     * @param string $baseApiUrl
     */
    public function __construct(ClientInterface $client, string $apiKey, string $baseApiUrl)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->baseApiUrl = $baseApiUrl;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function auth(): void
    {
        $response = $this->client->request('POST', $this->baseApiUrl, [
            'form_params' => [
                '__auth' => $this->apiKey
            ]
        ])->getBody()->getContents();

        $decodeResponse = json_decode($response, true);

        $this->accessToken = $decodeResponse['access_token'];
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}