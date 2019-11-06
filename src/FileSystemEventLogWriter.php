<?php declare(strict_types = 1);
namespace Eventsourcing;

class FileSystemEventLogWriter implements EventLogWriter {

    /** @var string */
    private $path;

    public function __construct(string $path) {
        $this->path = $path;
    }

    public function write(EventLog $log): void {
        foreach($log as $event) {
            $serialized = \serialize($event) . "\n";

            file_put_contents($this->path, $serialized, FILE_APPEND);
        }
    }

}
