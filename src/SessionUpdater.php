<?php declare(strict_types = 1);
namespace Eventsourcing;

class SessionUpdater implements EventListener {

    /** @var SessionService */
    private $sessionService;

    public function __construct(SessionService $sessionService) {
        $this->sessionService = $sessionService;
    }

    public function notify(Event $event): void {
        if (!$event instanceof CheckoutStartedEvent) {
            return;
        }

        $this->sessionService->updateCheckoutId(
            $event->emitterId()
        );
    }

}
