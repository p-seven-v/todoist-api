<?php

declare(strict_types=1);

namespace P7v\Todoist;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use P7v\Todoist\Entities\Project;

class TodoistClient
{
    /** @var string */
    public $token;

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

    /**
     * @return Project[]
     */
    public function getAllProjects(): array
    {
        $response = $this->httpClient->get('projects')
            ->getBody()
            ->getContents();

        $records = json_decode($response, true);

        return array_map(function (array $record) {
            return new Project($record['id'], $record['name'], $record['order'], $record['indent'], $record['comment_count']);
        }, $records);
    }

    public function createNewProject(string $name): Project
    {
        $response = $this->httpClient->post('projects', [
            'json' => [
                'name' => $name
            ]
        ])->getBody()->getContents();

        $record = json_decode($response, true);

        return new Project($record['id'], $record['name'], $record['order'], $record['indent'], $record['comment_count']);
    }

    public function getProject(int $id): Project
    {
        $url = 'projects/' . $id;

        $response = $this->httpClient->get($url)
            ->getBody()
            ->getContents();

        $record = json_decode($response, true);

        return new Project($record['id'], $record['name'], $record['order'], $record['indent'], $record['comment_count']);
    }

    public function updateProject(Project $project): bool
    {
        $url = 'projects/' . $project->getId();

        $this->httpClient->post($url, [
            'json' => [
                'name' => $project->getName(),
            ]
        ]);

        return true;
    }

    public function deleteProject(Project $project): bool
    {
        $url = 'projects/' . $project->getId();

        $this->httpClient->delete($url);

        return true;
    }
}
