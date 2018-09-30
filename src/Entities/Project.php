<?php declare(strict_types=1);

namespace P7v\Todoist\Entities;

class Project
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var int */
    private $order;

    /** @var int */
    private $indent;

    /** @var int */
    private $commentCount;

    public function __construct(int $id, string $name, int $order, int $indent, int $commentCount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->order = $order;
        $this->indent = $indent;
        $this->commentCount = $commentCount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getIndent(): int
    {
        return $this->indent;
    }

    public function setIndent(int $indent): self
    {
        $this->indent = $indent;

        return $this;
    }

    public function getCommentCount(): int
    {
        return $this->commentCount;
    }

    public function setCommentCount(int $commentCount): self
    {
        $this->commentCount = $commentCount;

        return $this;
    }
}
