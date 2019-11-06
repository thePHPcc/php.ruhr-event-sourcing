<?php declare(strict_types = 1);
namespace Eventsourcing;

use DateTimeImmutable;
use RuntimeException;

class Checkout extends EventSourced {

    /** @var null|BillingAddress */
    private $billingAddress;

    /** @var null|CartItemCollection */
    private $cartItems;

    /** @var bool */
    private $started = false;

    /** @var null|EmitterId */
    private $id;

    public function start(CartItemCollection $cartItems): EmitterId {
        if ($cartItems->count() === 0) {
            throw new RuntimeException('Can not start for empty collections');
        }

        $id = new EmitterId(trim(exec('uuidgen')));
        $this->handle(new CheckoutStartedEvent(
            new DateTimeImmutable('now'),
            $id, $cartItems
        ));

        return $id;
    }

    public function setBillingAddress(BillingAddress $address): void {
        if (!$this->started) {
            throw new RuntimeException('Checkout not started');
        }

        $this->handle(new BillingAddressSetEvent(
            new DateTimeImmutable('now'),
            $this->id, $address));
    }

    public function snapshot(): SnapshotEvent {
        $properties = \get_object_vars($this);

        return new SnapshotEvent(
            $this->id,
            new DateTimeImmutable('now'),
            $properties
        );
    }

    protected function applyEvent(Event $event): void {
        if ($event instanceof CheckoutStartedEvent) {
            $this->applyCheckoutStartedEvent($event);
            return;
        }

        if ($event instanceof BillingAddressSetEvent) {
            $this->applyBillingAddressEvent($event);
        }

        if ($event instanceof SnapshotEvent) {
            $this->applySnapshotEvent($event);
        }
    }

    private function applyCheckoutStartedEvent(CheckoutStartedEvent $event): void {
        $this->cartItems = $event->cartItems();
        $this->id = $event->emitterId();
        $this->started = true;
    }

    private function applyBillingAddressEvent(BillingAddressSetEvent $event): void {
        $this->billingAddress = $event->address();
    }

    private function applySnapshotEvent(SnapshotEvent $event): void {
        foreach($event->properties() as $property => $value) {
            $this->{$property} = $value;
        }
    }

}
