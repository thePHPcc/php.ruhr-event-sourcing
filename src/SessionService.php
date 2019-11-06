<?php declare(strict_types = 1);
namespace Eventsourcing;

class SessionService {

    /** @var SessionId */
    private $sessionid;

    /** @var EmitterId|null */
    private $checkoutId;

    public function __construct(SessionId $sessionid) {
        $this->sessionid = $sessionid;
    }

    public function sessionid(): SessionId {
        return $this->sessionid;
    }

    public function updateCheckoutId(EmitterId $emitterId) {
        $this->checkoutId = $emitterId;
    }

    public function hasCheckout(): bool {
        return $this->checkoutId !== null;
    }

    public function checkoutId(): EmitterId {
        return $this->checkoutId;
    }

    public function persist(): void {
        file_put_contents(
            '/tmp/checkout/' . $this->sessionid->asString() . '.session',
            \serialize($this)
        );
    }
}
