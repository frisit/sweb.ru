<?php

namespace App\Event;

/**
 * Class Event
 * @package App\Event
 */
class Event
{
    /**
     * @var null
     */
    private $subjetc;

    /**
     * @var array
     */
    private array $arguments;

    /**
     * Event constructor.
     * @param null $subject
     * @param array $arguments
     */
    public function __construct($subject = null, array $arguments = [])
    {
        $this->subjetc = $subject;
        $this->arguments = $arguments;
    }

    /**
     * @return null
     */
    public function getSubject()
    {
        return $this->subjetc;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }


}