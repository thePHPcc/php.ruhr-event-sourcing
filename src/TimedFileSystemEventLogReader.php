<?php declare(strict_types = 1);
namespace Eventsourcing;

use DateTimeImmutable;

class TimedFileSystemEventLogReader implements EventLogReader {

    /** @var string */
    private $path;

    /** @var DateTimeImmutable */
    private $till;

    public function __construct(string $path, DateTimeImmutable $till) {
        $this->path = $path;
        $this->till = $till;
    }

    public function read(EmitterId $id): EventLog {
        $fname = sprintf('%s/%s.events',
            $this->path,
            $id->asString()
        );

        $events = file($fname);
        $log = new EventLog;

        foreach($events as $serialized) {
            /** @var Event $event */
            $event = \unserialize($serialized);

            if ($event->createdAt() > $this->till) {
                break;
            }

            $log->add($event);
        }

        return $log;
    }

}
