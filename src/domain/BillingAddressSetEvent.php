<?php declare(strict_types = 1);
namespace Eventsourcing;

class BillingAddressSetEvent implements Event {

    /** @var BillingAddress */
    private $address;

    public function __construct(BillingAddress $address) {
        $this->address = $address;
    }

    public function address(): BillingAddress {
        return $this->address;
    }

}
