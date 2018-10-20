<?php

declare(strict_types=1);

namespace P7v\Todoist\Entities;

class Due
{
    /** @var string */
    protected $string;

    /** @var string */
    protected $date;

    /** @var string */
    protected $datetime;

    /** @var string */
    protected $timezone;

    public function __construct(string $string, string $date, string $datetime, string $timezone)
    {
        $this->string = $string;
        $this->date = $date;
        $this->datetime = $datetime;
        $this->timezone = $timezone;
    }

    public function getString(): string
    {
        return $this->string;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getDatetime(): string
    {
        return $this->datetime;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }
}
