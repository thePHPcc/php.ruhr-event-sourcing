<?php declare(strict_types = 1);
namespace Eventsourcing;

class EmitterId {

    /** @var string */
    private $value;

    public function __construct(string $value) {
        $this->value = $value;
    }

    public function asString(): string {
        return $this->value;
    }
}
