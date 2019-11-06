<?php declare(strict_types = 1);
namespace Eventsourcing;

class BillingAddressSetEvent implements Event {

    /** @var BillingAddress */
    private $address;

    /** @var EmitterId */
    private $checkoutId;

    public function __construct(EmitterId $checkoutId, BillingAddress $address) {
        $this->checkoutId = $checkoutId;
        $this->address = $address;
    }

    public function address(): BillingAddress {
        return $this->address;
    }

    public function emitterId(): EmitterId {
        return $this->checkoutId;
    }

}
