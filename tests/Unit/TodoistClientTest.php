<?php

declare(strict_types=1);

namespace Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use P7v\Todoist\Entities\Project;
use P7v\Todoist\TodoistClient;
use PHPUnit\Framework\TestCase;

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
                'id'            => 1,
                'name'          => 'Inbox',
                'order'         => 0,
                'indent'        => 1,
                'comment_count' => 0,
            ],
            [
                'id'            => 2,
                'name'          => 'Personal',
                'order'         => 1,
                'indent'        => 1,
                'comment_count' => 3,
            ],
            [
                'id'            => 3,
                'name'          => 'Work',
                'order'         => 2,
                'indent'        => 1,
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
}
