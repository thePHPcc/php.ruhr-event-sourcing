<?php declare(strict_types = 1);
namespace Eventsourcing;

use RuntimeException;

class Checkout {

    /** @var EventLog */
    private $eventLog;

    /** @var BillingAddress */
    private $billingAddress;

    /** @var CartItemCollection */
    private $cartItems;

    /** @var bool */
    private $started = false;

    public function __construct(EventLog $eventLog) {
        $this->replay($eventLog);
        $this->eventLog = new EventLog();
    }

    public function start(CartItemCollection $cartItems): void {
        if ($cartItems->count() === 0) {
            throw new RuntimeException('Can not start for empty collections');
        }
        $event = new CheckoutStartedEvent($cartItems);
        $this->eventLog->add($event);
        $this->applyCheckoutStartedEvent($event);
    }

    public function setBillingAddress(BillingAddress $address): void {
        if (!$this->started) {
            throw new RuntimeException('Checkout not started');
        }

        $event = new BillingAddressSetEvent($address);
        $this->eventLog->add($event);
        $this->applyBillingAddressEvent($event);
    }

    public function changes(): EventLog {
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
        $this->started = true;
    }

    private function replay(EventLog $eventLog): void {
        foreach($eventLog as $event) {
            /** @var Event $event */

            if ($event instanceof CheckoutStartedEvent) {
                $this->applyCheckoutStartedEvent($event);
                continue;
            }

            if ($event instanceof BillingAddressSetEvent) {
                $this->applyBillingAddressEvent($event);
            }
        }
    }
}
