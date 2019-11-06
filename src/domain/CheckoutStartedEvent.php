<?php declare(strict_types = 1);
namespace Eventsourcing;

use DateTimeImmutable;

class CheckoutStartedEvent implements Event {

    /** @var CartItemCollection */
    private $cartItems;

    /** @var EmitterId */
    private $checkoutId;

    /** @var DateTimeImmutable */
    private $createdTime;

    public function __construct(DateTimeImmutable $createdTime, EmitterId $checkoutId, CartItemCollection $cartItems) {
        $this->createdTime = $createdTime;
        $this->checkoutId = $checkoutId;
        $this->cartItems = $cartItems;
    }

    public function cartItems(): CartItemCollection {
        return $this->cartItems;
    }

    public function emitterId(): EmitterId {
        return $this->checkoutId;
    }

    public function createdAt(): DateTimeImmutable {
        return $this->createdTime;
    }

}
