<?php declare(strict_types = 1);
namespace Eventsourcing;

use DateTimeImmutable;

class BillingAddressSetEvent implements Event {

    /** @var BillingAddress */
    private $address;

    /** @var EmitterId */
    private $checkoutId;

    /** @var DateTimeImmutable */
    private $createdTime;

    public function __construct(DateTimeImmutable $createdTime, EmitterId $checkoutId, BillingAddress $address) {
        $this->createdTime = $createdTime;
        $this->checkoutId = $checkoutId;
        $this->address = $address;
    }

    public function address(): BillingAddress {
        return $this->address;
    }

    public function emitterId(): EmitterId {
        return $this->checkoutId;
    }

    public function createdAt(): DateTimeImmutable {
        return $this->createdTime;
    }
}
