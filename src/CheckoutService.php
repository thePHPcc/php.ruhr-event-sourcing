<?php declare(strict_types = 1);
namespace Eventsourcing;

class CheckoutService {

    /** @var CartService */
    private $cartService;

    /** @var EventLogWriter */
    private $writer;

    /** @var EventLogReader */
    private $reader;

    /** @var SessionService */
    private $session;

    public function __construct(CartService $cartService, SessionService $session, EventLogWriter $writer, EventLogReader $reader) {
        $this->cartService = $cartService;
        $this->session = $session;
        $this->writer = $writer;
        $this->reader = $reader;
    }

    public function start(): void {
        $cartItems = $this->cartService->getCartItems(
            $this->session->sessionid()
        );
        $checkout = new Checkout(new EventLog());
        $this->session->updateCheckoutId(
            $checkout->start($cartItems)
        );
        $this->writer->write($checkout->changes());
    }

    public function defineBillingAddress(BillingAddress $address): void {
        $checkout = $this->loadCheckout();
        $checkout->setBillingAddress($address);
        $this->writer->write($checkout->changes());
    }

    private function loadCheckout(): Checkout {
        if ($this->session->hasCheckout()) {
            $log = $this->reader->read($this->session->checkoutId());
        } else {
            $log = new EventLog();
        }
        return new Checkout($log);
    }
}
