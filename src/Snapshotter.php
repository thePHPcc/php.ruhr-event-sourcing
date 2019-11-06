<?php declare(strict_types = 1);
namespace Eventsourcing;

class Snapshotter {

    /** @var EventLogReader */
    private $reader;

    /** @var EventLogWriter */
    private $writer;

    public function __construct(EventLogReader $reader, EventLogWriter $writer) {
        $this->reader = $reader;
        $this->writer = $writer;
    }

    public function snapshot(EmitterId $emitterId) {
        $eventLog = $this->reader->read($emitterId);

        $checkout = new Checkout($eventLog);
        $snapshot = $checkout->snapshot();

        $newlog = new EventLog();
        $newlog->add($snapshot);

        $this->writer->write($newlog);
    }
}
