<?php declare(strict_types=1);

namespace Tests\Unit;

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
}
