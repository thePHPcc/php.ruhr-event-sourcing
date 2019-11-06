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

    /** @var EventDispatcher */
    private $dispatcher;

    public function __construct(CartService $cartService, SessionService $session, EventLogWriter $writer, EventLogReader $reader, EventDispatcher $dispatcher) {
        $this->cartService = $cartService;
        $this->session = $session;
        $this->writer = $writer;
        $this->reader = $reader;
        $this->dispatcher = $dispatcher;
    }

    public function start(): void {
        $cartItems = $this->cartService->getCartItems(
            $this->session->sessionid()
        );
        $checkout = new Checkout(new EventLog());
        $checkout->start($cartItems);
        $this->persist($checkout);
    }

    public function defineBillingAddress(BillingAddress $address): void {
        $checkout = $this->loadCheckout();
        $checkout->setBillingAddress($address);
        $this->persist($checkout);
    }

    private function loadCheckout(): Checkout {
        if ($this->session->hasCheckout()) {
            $log = $this->reader->read($this->session->checkoutId());
        } else {
            $log = new EventLog();
        }
        return new Checkout($log);
    }

    private function persist(Checkout $checkout): void {
        $log = $checkout->changes();
        $this->writer->write($log);

        foreach($log as $event) {
            $this->dispatcher->dispatch($event);
        }
    }
}
