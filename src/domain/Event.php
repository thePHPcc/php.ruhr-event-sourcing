<?php declare(strict_types = 1);
namespace Eventsourcing;

use DateTimeImmutable;

interface Event {
    public function emitterId(): EmitterId;
    public function createdAt(): DateTimeImmutable;
}
