<?php declare(strict_types=1);

namespace P7v\Todoist;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class TodoistClient
{
    /** @var string */
    public $token;

    /** @var Client */
    private $httpClient;

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->initializeHttpClient();
    }

    private function initializeHttpClient()
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://beta.todoist.com/API/v8/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
            RequestOptions::TIMEOUT => 1,
            RequestOptions::CONNECT_TIMEOUT => 1,
            RequestOptions::READ_TIMEOUT => 1,
        ]);
    }

    public function getAllProjects(): array
    {
        $response = $this->httpClient->get('projects')
            ->getBody()
            ->getContents();

        return json_decode($response, true);
    }
}
