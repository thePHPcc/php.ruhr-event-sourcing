<?php declare(strict_types = 1);
namespace Eventsourcing;

class CheckoutStartedEvent {

    /** @var CartItemCollection */
    private $cartItems;

    public function __construct(CartItemCollection $cartItems) {
        $this->cartItems = $cartItems;
    }

    public function cartItems(): CartItemCollection {
        return $this->cartItems;
    }

}
