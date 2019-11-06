<?php declare(strict_types = 1);
namespace Eventsourcing;

use ArrayIterator;
use IteratorAggregate;

class EventLog implements IteratorAggregate {

    /** @var Event[] */
    private $events = [];

    public function add(Event $event): void {
        $this->events[] = $event;
    }

    public function getIterator(): ArrayIterator {
        return new ArrayIterator($this->events);
    }

}
