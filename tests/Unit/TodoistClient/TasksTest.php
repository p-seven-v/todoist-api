<?php

declare(strict_types=1);

namespace Tests\Unit\TodoistClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use P7v\Todoist\Entities\Task;
use P7v\Todoist\TodoistClient;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;

class TasksTest extends TestCase
{
    /** @test */
    public function it_gets_list_of_all_tasks()
    {
        $response = [
            [
                'id' => 987654321,
                'project_id' => 123456,
                'content' => 'Great idea',
                'completed' => false,
                'label_ids' => [],
                'order' => 1,
                'indent' => 1,
                'priority' => 2,
                'comment_count' => 0,
                'url' => "https://todoist.com/showTask?id=987654321",
            ],
            [
                'id' => 9090909090,
                'project_id' => 98888888,
                'content' => 'Great idea 2',
                'completed' => false,
                'label_ids' => [],
                'order' => 2,
                'indent' => 1,
                'priority' => 3,
                'comment_count' => 2,
                'due' => [
                    'string' => 'Oct 22',
                    'date' => '2018-10-22',
                ],
                'url' => "https://todoist.com/showTask?id=9090909090",
            ],
        ];

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode($response)),
        ]);
        $guzzle = new Client(['handler' => $mockHandler]);

        $client = new TodoistClient('random_token', $guzzle);

        $tasks = $client->getAllTasks();

        foreach ($tasks as $task) {
            $this->assertInstanceOf(Task::class, $task);
        }

        $this->assertEquals('Oct 22', $tasks[1]->getDue()->getString());
        $this->assertEquals('2018-10-22', $tasks[1]->getDue()->getDate());
    }
}
