<?php

declare(strict_types=1);

namespace P7v\Todoist\Entities;

class Label
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var int */
    private $order;

    public function __construct(int $id, string $name, int $order)
    {
        $this->id = $id;
        $this->name = $name;
        $this->order = $order;
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
}
