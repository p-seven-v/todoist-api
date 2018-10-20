<?php

declare(strict_types=1);

namespace P7v\Todoist\Concerns;

use GuzzleHttp\Client;
use P7v\Todoist\Entities\Due;
use P7v\Todoist\Entities\Task;

trait ManagesTasks
{
    /** @var Client */
    private $httpClient;

    /**
     * @return Task[]
     */
    public function getAllTasks(): array
    {
        $response = $this->httpClient->get('tasks')
            ->getBody()
            ->getContents();

        $records = json_decode($response, true);

        return array_map(function (array $record) {
            $task = new Task(
                $record['id'],
                $record['project_id'],
                $record['content'],
                $record['completed'],
                $record['label_ids'],
                $record['order'],
                $record['indent'],
                $record['priority'],
                $record['url'],
                $record['comment_count']
            );

            if (array_key_exists('due', $record)) {
                $due = new Due(
                    $record['due']['string'],
                    $record['due']['date'],
                    array_key_exists('datetime', $record['due']) ? $record['due']['datetime'] : null,
                    array_key_exists('timezone', $record['due']) ? $record['due']['timezone'] : null
                );

                $task->setDue($due);
            }

            return $task;
        }, $records);
    }
}
