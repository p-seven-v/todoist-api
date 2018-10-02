<?php

declare(strict_types=1);

namespace Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use P7v\Todoist\TodoistClient;
use PHPUnit\Framework\TestCase;
use P7v\Todoist\Entities\Project;
use GuzzleHttp\Handler\MockHandler;

class TodoistClientTest extends TestCase
{
    /** @test */
    public function it_accepts_api_token_in_constructor()
    {
        $token = 'somegibberishfor32symbols1231231';

        $this->assertEquals($token, (new TodoistClient($token))->token);
    }

    /** @test */
    public function it_gets_list_of_all_projects()
    {
        $response = [
            [
                'id' => 1,
                'name' => 'Inbox',
                'order' => 0,
                'indent' => 1,
                'comment_count' => 0,
            ],
            [
                'id' => 2,
                'name' => 'Personal',
                'order' => 1,
                'indent' => 1,
                'comment_count' => 3,
            ],
            [
                'id' => 3,
                'name' => 'Work',
                'order' => 2,
                'indent' => 1,
                'comment_count' => 4,
            ],
        ];

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode($response)),
        ]);
        $guzzle = new Client(['handler' => $mockHandler]);

        $client = new TodoistClient('random_token', $guzzle);

        $projects = $client->getAllProjects();
        foreach ($projects as $project) {
            $this->assertInstanceOf(Project::class, $project);
        }

        foreach (array_keys($response) as $i) {
            $this->assertEquals($response[$i]['id'], $projects[$i]->getId());
            $this->assertEquals($response[$i]['name'], $projects[$i]->getName());
            $this->assertEquals($response[$i]['order'], $projects[$i]->getOrder());
            $this->assertEquals($response[$i]['indent'], $projects[$i]->getIndent());
            $this->assertEquals($response[$i]['comment_count'], $projects[$i]->getCommentCount());
        }
    }

    /** @test */
    public function it_creates_new_project()
    {
        $response = [
            'id' => 1111,
            'name' => 'New project 22',
            'order' => 30,
            'indent' => 1,
            'comment_count' => 0
        ];

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode($response))
        ]);

        $guzzle = new Client(['handler' => $mockHandler]);

        $client = new TodoistClient('random_token', $guzzle);

        $newProject = $client->createNewProject('New project 22');

        $this->assertEquals(1111, $newProject->getId());
        $this->assertEquals('New project 22', $newProject->getName());
        $this->assertEquals(30, $newProject->getOrder());
        $this->assertEquals(1, $newProject->getIndent());
        $this->assertEquals(0, $newProject->getCommentCount());
    }

    /** @test */
    public function it_fetches_one_project_by_id()
    {
        $response = [
            'id' => 1,
            'name' => 'Inbox',
            'order' => 0,
            'indent' => 1,
            'comment_count' => 0,
        ];

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode($response))
        ]);

        $guzzle = new Client(['handler' => $mockHandler]);

        $client = new TodoistClient('random_token', $guzzle);

        $project = $client->getProject(1);

        $this->assertEquals(1, $project->getId());
        $this->assertEquals('Inbox', $project->getName());
        $this->assertEquals(0, $project->getOrder());
        $this->assertEquals(1, $project->getIndent());
        $this->assertEquals(0, $project->getCommentCount());
    }

    /** @test */
    public function it_updates_project_data()
    {
        $response = [
            'id' => 1,
            'name' => 'Inbox',
            'order' => 0,
            'indent' => 1,
            'comment_count' => 0,
        ];

        $handler = new MockHandler([
            new Response(200, [], json_encode($response)),
            new Response(204)
        ]);

        $guzzle = new Client(compact('handler'));

        $client = new TodoistClient('random_token', $guzzle);

        $project = $client->getProject(1);

        $project->setName('Inbox 2');

        $this->assertTrue($client->updateProject($project));
    }

    /** @test */
    public function it_deletes_project()
    {
        $response = [
            'id' => 1,
            'name' => 'Inbox',
            'order' => 0,
            'indent' => 1,
            'comment_count' => 0,
        ];

        $handler = new MockHandler([
            new Response(200, [], json_encode($response)),
            new Response(204)
        ]);

        $guzzle = new Client(compact('handler'));

        $client = new TodoistClient('random_token', $guzzle);

        $project = $client->getProject(1);

        $this->assertTrue($client->deleteProject($project));
    }
}
