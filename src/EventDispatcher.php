<?php declare(strict_types = 1);
namespace Eventsourcing;

class EventDispatcher {

    /** @var EventListener[] */
    private $listener;

    public function addListener(EventListener $listener) {
        $this->listener[] = $listener;
    }

    public function dispatch(Event $event): void {
        foreach($this->listener as $listener) {
            $listener->notify($event);
        }
    }
}
