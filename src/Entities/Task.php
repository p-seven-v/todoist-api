<?php

declare(strict_types=1);

namespace P7v\Todoist\Entities;

use Webmozart\Assert\Assert;

class Task
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $projectId;

    /** @var string */
    protected $content;

    /** @var bool */
    protected $completed;

    /** @var array */
    protected $labelsIds;

    /** @var int */
    protected $order;

    /** @var int */
    protected $indent;

    /** @var int */
    protected $priority;

    /** @var Due */
    protected $due;

    /** @var string */
    protected $url;

    /** @var int */
    protected $commentCount;

    public function __construct(int $id, int $projectId, string $content, bool $completed, array $labelsIds, int $order, int $indent, int $priority, string $url, int $commentCount)
    {
        $this->id = $id;
        $this->projectId = $projectId;
        $this->content = $content;
        $this->completed = $completed;
        $this->labelsIds = $labelsIds;
        $this->indent = $indent;
        $this->order = $order;
        $this->priority = $priority;
        $this->url = $url;
        $this->commentCount = $commentCount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getLabelsIds(): array
    {
        return $this->labelsIds;
    }

    public function setLabelsIds(array $labelsIds): self
    {
        Assert::allInteger($labelsIds, 'Only integers are allowed for label ids.');

        $this->labelsIds = $labelsIds;

        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getIndent(): int
    {
        return $this->indent;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority)
    {
        Assert::range($priority, 1, 4, 'Priority can be from 1 to 4.');

        $this->priority = $priority;

        return $this;
    }

    public function getDue()
    {
        return $this->due;
    }

    public function setDue(Due $due): self
    {
        $this->due = $due;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCommentCount(): int
    {
        return $this->commentCount;
    }
}
