<?php

declare(strict_types=1);

namespace Tests\Unit\Entities;

use P7v\Todoist\Entities\Due;
use PHPUnit\Framework\TestCase;

class DueTest extends TestCase
{
    /** @var Due */
    private $subject;

    protected function setUp()
    {
        $this->subject = new Due('tomorrow at 12', '2018-10-20', '2018-10-20T09:00:00Z', 'Europe/Kiev');
    }

    /** @test */
    public function it_gets_string()
    {
        $this->assertEquals('tomorrow at 12', $this->subject->getString());
    }

    /** @test */
    public function it_gets_date()
    {
        $this->assertEquals('2018-10-20', $this->subject->getDate());
    }

    /** @test */
    public function it_gets_datetime()
    {
        $this->assertEquals('2018-10-20T09:00:00Z', $this->subject->getDatetime());
    }

    /** @test */
    public function it_gets_timezone()
    {
        $this->assertEquals('Europe/Kiev', $this->subject->getTimezone());
    }
}
