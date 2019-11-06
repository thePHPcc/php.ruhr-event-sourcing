<?php declare(strict_types = 1);
namespace Eventsourcing;

class BillingAddressSetEvent implements Event {

    /** @var BillingAddress */
    private $address;

    /** @var CheckoutId */
    private $checkoutId;

    public function __construct(CheckoutId $checkoutId, BillingAddress $address) {
        $this->checkoutId = $checkoutId;
        $this->address = $address;
    }

    public function address(): BillingAddress {
        return $this->address;
    }

    public function checkoutId(): CheckoutId {
        return $this->checkoutId;
    }

}
