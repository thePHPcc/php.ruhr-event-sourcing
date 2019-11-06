<?php declare(strict_types = 1);
namespace Eventsourcing;

class Checkout {

    /** @var array */
    private $eventLog = [];

    /** @var BillingAddress */
    private $billingAddress;

    /** @var CartItemCollection */
    private $cartItems;

    public function start(CartItemCollection $cartItems): void {
        $event = new CheckoutStartedEvent($cartItems);
        $this->eventLog[] = $event;
        $this->applyCheckoutStartedEvent($event);
    }

    public function setBillingAddress(BillingAddress $address): void {
        $event = new BillingAddressSetEvent($address);
        $this->eventLog[] = $event;
        $this->applyBillingAddressEvent($event);
    }

    public function eventLog(): array {
        return $this->eventLog;
    }

    public function billingAddress(): BillingAddress {
        return $this->billingAddress;
    }

    private function applyBillingAddressEvent(BillingAddressSetEvent $event): void {
        $this->billingAddress = $event->address();
    }

    private function applyCheckoutStartedEvent(CheckoutStartedEvent $event): void {
        $this->cartItems = $event->cartItems();
    }

}
