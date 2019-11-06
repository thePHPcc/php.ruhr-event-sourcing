<?php declare(strict_types = 1);
namespace Eventsourcing;

class Factory {

    public function createCheckoutService(SessionId $sid): CheckoutService {

        $sessionService = new SessionService($sid);

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(
            new CheckoutStartedListener(
                $sessionService
            )
        );

        return new CheckoutService(
            new CartService(),
            $sessionService,
            new FileSystemEventLogWriter('/tmp/checkout'),
            new FileSystemEventLogReader('/tmp/checkout'),
            $dispatcher
        );

    }
}
