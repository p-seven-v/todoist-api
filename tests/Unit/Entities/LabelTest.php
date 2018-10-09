<?php

declare(strict_types=1);

namespace Tests\Unit\Entities;

use P7v\Todoist\Entities\Label;
use PHPUnit\Framework\TestCase;

class LabelTest extends TestCase
{
    /** @var Label */
    private $subject;

    protected function setUp()
    {
        $this->subject = new Label(1, 'Label 1', 1);
    }

    /** @test */
    public function it_gets_id()
    {
        $this->assertEquals(1, $this->subject->getId());
    }

    /** @test */
    public function it_gets_and_sets_name()
    {
        $this->assertEquals('Label 1', $this->subject->getName());

        $this->subject->setName('Very important');

        $this->assertEquals('Very important', $this->subject->getName());
    }

    /** @test */
    public function it_gets_and_sets_order()
    {
        $this->assertEquals(1, $this->subject->getOrder());

        $this->subject->setOrder(2);

        $this->assertEquals(2, $this->subject->getOrder());
    }
}
