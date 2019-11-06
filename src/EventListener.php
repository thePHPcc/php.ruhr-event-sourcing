<?php declare(strict_types = 1);
namespace Eventsourcing;

interface EventListener {

    public function notify(Event $event): void;
}
