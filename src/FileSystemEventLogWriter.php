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
            /** @var Event $event */
            $serialized = \serialize($event) . "\n";

            file_put_contents(
                sprintf('%s/%s.events',
                    $this->path,
                    $event->emitterId()->asString()
                ),
                $serialized, FILE_APPEND);
        }
    }

}
