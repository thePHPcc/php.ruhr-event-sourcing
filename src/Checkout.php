<?php declare(strict_types = 1);
namespace Eventsourcing;

use RuntimeException;

class Checkout extends EventSourced {

    /** @var BillingAddress */
    private $billingAddress;

    /** @var CartItemCollection */
    private $cartItems;

    /** @var bool */
    private $started = false;

    public function start(CartItemCollection $cartItems): void {
        if ($cartItems->count() === 0) {
            throw new RuntimeException('Can not start for empty collections');
        }

        $this->handle(new CheckoutStartedEvent($cartItems));
    }

    public function setBillingAddress(BillingAddress $address): void {
        if (!$this->started) {
            throw new RuntimeException('Checkout not started');
        }

        $this->handle(new BillingAddressSetEvent($address));
    }

    protected function applyEvent(Event $event): void {
        if ($event instanceof CheckoutStartedEvent) {
            $this->applyCheckoutStartedEvent($event);
            return;
        }

        if ($event instanceof BillingAddressSetEvent) {
            $this->applyBillingAddressEvent($event);
        }
    }

    private function applyBillingAddressEvent(BillingAddressSetEvent $event): void {
        $this->billingAddress = $event->address();
    }

    private function applyCheckoutStartedEvent(CheckoutStartedEvent $event): void {
        $this->cartItems = $event->cartItems();
        $this->started = true;
    }
}
