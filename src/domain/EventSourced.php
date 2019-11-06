<?php declare(strict_types = 1);
namespace Eventsourcing;

abstract class EventSourced {

    /** @var EventLog */
    private $eventLog;

    public function __construct(EventLog $eventLog) {
        $this->replay($eventLog);
        $this->eventLog = new EventLog();
    }

    public function changes(): EventLog {
        return $this->eventLog;
    }

    private function replay(EventLog $eventLog): void {
        foreach($eventLog as $event) {
            /** @var Event $event */
            $this->applyEvent($event);
        }
    }

    abstract protected function applyEvent(Event $event): void;

    protected function handle(Event $event): void {
        $this->eventLog->add($event);
        $this->applyEvent($event);
    }

}
