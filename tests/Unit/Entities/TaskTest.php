<?php

 declare(strict_types=1);

namespace Tests\Unit\Entities;

use P7v\Todoist\Entities\Due;
use P7v\Todoist\Entities\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    /** @var Task */
    private $subject;

    /** @var Due */
    private $due;

    protected function setUp()
    {
        $this->due = new Due('tomorrow at 12', '2018-10-20', '2018-10-20T09:00:00Z', 'Europe/Kiev');

        $this->subject = new Task(
            111,
            2,
            'Do some important stuff',
            false,
            [1, 3],
            12,
            1,
            3,
            $this->due,
            'http://example.com/todoist/111',
            33
        );
    }

    /** @test */
    public function it_gets_id()
    {
        $this->assertEquals(111, $this->subject->getId());
    }

    /** @test */
    public function it_gets_project_id()
    {
        $this->assertEquals(2, $this->subject->getProjectId());
    }

    /** @test */
    public function it_gets_and_sets_content()
    {
        $this->assertEquals('Do some important stuff', $this->subject->getContent());

        $this->subject->setContent('Do some important stuff!!!');

        $this->assertEquals('Do some important stuff!!!', $this->subject->getContent());
    }

    /** @test */
    public function it_gets_and_sets_completed()
    {
        $this->assertFalse($this->subject->isCompleted());

        $this->subject->setCompleted(true);

        $this->assertTrue($this->subject->isCompleted());
    }

    /** @test */
    public function it_gets_and_sets_labels_ids()
    {
        $this->assertEquals([1, 3], $this->subject->getLabelsIds());

        $this->subject->setLabelsIds([3, 4]);

        $this->assertEquals([3, 4], $this->subject->getLabelsIds());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Only integers are allowed for label ids.
     */
    public function it_cannot_set_labels_ids_to_not_integers()
    {
        $this->subject->setLabelsIds(['x', 'y', 'z']);
    }

    /** @test */
    public function it_gets_order()
    {
        $this->assertEquals(12, $this->subject->getOrder());
    }

    /** @test */
    public function it_gets_indent()
    {
        $this->assertEquals(1, $this->subject->getIndent());
    }

    /** @test */
    public function it_gets_and_sets_priority()
    {
        $this->assertEquals(3, $this->subject->getPriority());

        $this->subject->setPriority(4);

        $this->assertEquals(4, $this->subject->getPriority());
    }

    /**
     * @test
     * @dataProvider invalidPriorities
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Priority can be from 1 to 4.
     * @param int $priority
     */
    public function it_cannot_set_priority_to_invalid_values(int $priority)
    {
        $this->subject->setPriority($priority);
    }

    public function invalidPriorities(): array
    {
        return [
            [0],
            [5],
            [100],
            [9000],
        ];
    }

    /** @test */
    public function it_gets_due_object()
    {
        $this->assertEquals($this->due, $this->subject->getDue());
    }

    /** @test */
    public function it_gets_and_sets_url()
    {
        $this->assertEquals('http://example.com/todoist/111', $this->subject->getUrl());

        $this->subject->setUrl('http://example.com/todoist/new/111');

        $this->assertEquals('http://example.com/todoist/new/111', $this->subject->getUrl());
    }
    
    /** @test */
    public function it_gets_comment_count()
    {
        $this->assertEquals(33, $this->subject->getCommentCount());
    }

}
