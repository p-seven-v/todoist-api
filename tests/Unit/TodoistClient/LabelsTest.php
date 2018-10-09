<?php

declare(strict_types=1);

namespace Tests\Unit\TodoistClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use P7v\Todoist\TodoistClient;
use P7v\Todoist\Entities\Label;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;

class LabelsTest extends TestCase
{
    /** @test */
    public function it_gets_list_of_all_labels()
    {
        $response = [
            [
                'id' => 123,
                'name' => 'Very important',
                'order' => 1,
            ],
            [
                'id' => 126,
                'name' => 'Quite important',
                'order' => 2,
            ],
        ];

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode($response)),
        ]);
        $guzzle = new Client(['handler' => $mockHandler]);

        $client = new TodoistClient('random_token', $guzzle);

        $labels = $client->getAllLabels();
        foreach ($labels as $label) {
            $this->assertInstanceOf(Label::class, $label);
        }

        foreach (array_keys($response) as $i) {
            $this->assertEquals($response[$i]['id'], $labels[$i]->getId());
            $this->assertEquals($response[$i]['name'], $labels[$i]->getName());
            $this->assertEquals($response[$i]['order'], $labels[$i]->getOrder());
        }
    }

    /** @test */
    public function it_creates_new_label()
    {
        $response = [
            'id' => 111,
            'name' => 'New label',
            'order' => 3,
        ];

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode($response)),
        ]);

        $guzzle = new Client(['handler' => $mockHandler]);

        $client = new TodoistClient('random_token', $guzzle);

        $newLabel = $client->createNewLabel('New label', 3);

        $this->assertEquals(111, $newLabel->getId());
        $this->assertEquals('New label', $newLabel->getName());
        $this->assertEquals(3, $newLabel->getOrder());
    }

    /** @test */
    public function it_gets_label_by_id()
    {
        $response = [
            'id' => 222,
            'name' => 'Old label',
            'order' => 4,
        ];

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode($response)),
        ]);

        $guzzle = new Client(['handler' => $mockHandler]);

        $client = new TodoistClient('random_token', $guzzle);

        $label = $client->getLabel(222);

        $this->assertEquals(222, $label->getId());
        $this->assertEquals('Old label', $label->getName());
        $this->assertEquals(4, $label->getOrder());
    }

    /** @test */
    public function it_updates_label_data()
    {
        $response = [
            'id' => 1,
            'name' => 'First',
            'order' => 1,
        ];

        $handler = new MockHandler([
            new Response(200, [], json_encode($response)),
            new Response(204),
        ]);

        $guzzle = new Client(compact('handler'));

        $client = new TodoistClient('random_token', $guzzle);

        $label = $client->getLabel(1);

        $label->setName('Updated label name')
            ->setOrder(5);

        $this->assertTrue($client->updateLabel($label));
    }

    /** @test */
    public function it_deletes_project()
    {
        $response = [
            'id' => 333,
            'name' => 'not used label',
            'order' => 2,
        ];

        $handler = new MockHandler([
            new Response(200, [], json_encode($response)),
            new Response(204),
        ]);

        $guzzle = new Client(compact('handler'));

        $client = new TodoistClient('random_token', $guzzle);

        $label = $client->getLabel(333);

        $this->assertTrue($client->deletelabel($label));
    }
}
