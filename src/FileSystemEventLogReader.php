<?php declare(strict_types = 1);
namespace Eventsourcing;

class FileSystemEventLogReader implements EventLogReader {

    /** @var string */
    private $path;

    public function __construct(string $path) {
        $this->path = $path;
    }

    public function read(): EventLog {
        $events = file($this->path);
        $log = new EventLog;

        foreach($events as $serialized) {
            $event = \unserialize($serialized);
            $log->add($event);
        }

        return $log;
    }

}
