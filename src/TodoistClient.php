<?php

declare(strict_types=1);

namespace P7v\Todoist;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class TodoistClient
{
    use Concerns\ManagesProjects,
        Concerns\ManagesLabels;

    /** @var string */
    private $token;

    /** @var Client */
    private $httpClient;

    public function __construct(string $token, Client $httpClient = null)
    {
        $this->token = $token;
        $this->initializeHttpClient($httpClient);
    }

    private function initializeHttpClient(Client $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new Client([
            'base_uri' => 'https://beta.todoist.com/API/v8/',
            'headers'  => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
            RequestOptions::TIMEOUT         => 1,
            RequestOptions::CONNECT_TIMEOUT => 1,
            RequestOptions::READ_TIMEOUT    => 1,
        ]);
    }
}
