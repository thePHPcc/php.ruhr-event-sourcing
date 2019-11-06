<?php declare(strict_types = 1);
namespace Eventsourcing;

class CheckoutStartedEvent implements Event {

    /** @var CartItemCollection */
    private $cartItems;

    /** @var CheckoutId */
    private $checkoutId;

    public function __construct(CheckoutId $checkoutId, CartItemCollection $cartItems) {
        $this->checkoutId = $checkoutId;
        $this->cartItems = $cartItems;
    }

    public function cartItems(): CartItemCollection {
        return $this->cartItems;
    }

    public function checkoutId(): CheckoutId {
        return $this->checkoutId;
    }


}
