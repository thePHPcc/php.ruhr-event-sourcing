<?php declare(strict_types = 1);
namespace Eventsourcing;

class Factory {

    public function createCheckoutService(SessionId $sid): CheckoutService {

        $sessionService = $this->createSessionService($sid);

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(
            new SessionUpdater($sessionService)
        );

        $dispatcher->addListener(
            new ConfirmPageProjector(
                new ConfirmPageRenderer(
                    '/tmp/checkout',
                    $sessionService->sessionid()
                )
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

    private function createSessionService(SessionId $sid) {
        $fname = sprintf('/tmp/checkout/%s.session', $sid->asString());

        if (!file_exists($fname)) {
            return new SessionService($sid);
        }

        return \unserialize(
            \file_get_contents($fname)
        );
    }
}
