<?php declare(strict_types=1);

namespace Tests\Unit\Entities;

use PHPUnit\Framework\TestCase;
use P7v\Todoist\Entities\Project;

class ProjectTest extends TestCase
{
    /** @var Project */
    private $subject;

    protected function setUp()
    {
        $this->subject = new Project(1, 'Project 1', 1, 1, 13);
    }

    /** @test */
    public function it_gets_id()
    {
        $this->assertEquals(1, $this->subject->getId());
    }

    /** @test */
    public function it_gets_and_sets_name()
    {
        $this->assertEquals('Project 1', $this->subject->getName());

        $this->subject->setName('Project 2');

        $this->assertEquals('Project 2', $this->subject->getName());
    }

    /** @test */
    public function it_gets_and_sets_order()
    {
        $this->assertEquals(1, $this->subject->getOrder());

        $this->subject->setOrder(10);

        $this->assertEquals(10, $this->subject->getOrder());
    }

    /** @test */
    public function it_gets_and_sets_indent()
    {
        $this->assertEquals(1, $this->subject->getIndent());

        $this->subject->setIndent(2);

        $this->assertEquals(2, $this->subject->getIndent());
    }

    /** @test */
    public function it_gets_and_sets_comment_count()
    {
        $this->assertEquals(13, $this->subject->getCommentCount());

        $this->subject->setCommentCount(14);

        $this->assertEquals(14, $this->subject->getCommentCount());
    }
}
