<?php

declare(strict_types=1);

namespace P7v\Todoist\Concerns;

use GuzzleHttp\Client;
use P7v\Todoist\Entities\Project;

trait ManagesProjects
{
    /** @var Client */
    private $httpClient;

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
                'name' => $name,
            ],
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
            ],
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
