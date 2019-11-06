<?php declare(strict_types = 1);
namespace Eventsourcing;

class ConfirmPageProjector implements EventListener {

    /** @var ConfirmPageRenderer */
    private $renderer;

    public function __construct(ConfirmPageRenderer $renderer) {
        $this->renderer = $renderer;
    }

    public function notify(Event $event): void {
        if ($event instanceof CheckoutStartedEvent) {
            $this->renderer->renderCartItems($event->cartItems());
            return;
        }

        if ($event instanceof BillingAddressSetEvent) {
            $this->renderer->renderBillingAddress($event->address());
        }
    }

}
