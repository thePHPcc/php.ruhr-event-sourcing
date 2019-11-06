<?php declare(strict_types = 1);
namespace Eventsourcing;

class CheckoutStartedEvent implements Event {

    /** @var CartItemCollection */
    private $cartItems;

    /** @var EmitterId */
    private $checkoutId;

    public function __construct(EmitterId $checkoutId, CartItemCollection $cartItems) {
        $this->checkoutId = $checkoutId;
        $this->cartItems = $cartItems;
    }

    public function cartItems(): CartItemCollection {
        return $this->cartItems;
    }

    public function emitterId(): EmitterId {
        return $this->checkoutId;
    }


}
