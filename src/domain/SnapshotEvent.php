<?php declare(strict_types = 1);
namespace Eventsourcing;

use DateTimeImmutable;

class SnapshotEvent implements Event {

    /** @var EmitterId */
    private $id;

    /** @var \DateTimeImmutable */
    private $createdTime;

    /** @var array */
    private $properties;

    public function __construct(EmitterId $id, \DateTimeImmutable $createdTime, array $properties) {
        $this->id = $id;
        $this->createdTime = $createdTime;
        $this->properties = $properties;
    }

    public function emitterId(): EmitterId {
        return $this->id;
    }

    public function createdAt(): DateTimeImmutable {
        return $this->createdTime;
    }

    public function properties(): array {
        return $this->properties;
    }

}
