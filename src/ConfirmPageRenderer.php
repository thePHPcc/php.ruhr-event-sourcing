<?php declare(strict_types = 1);
namespace Eventsourcing;

class ConfirmPageRenderer {

    /** @var string */
    private $path;

    /** @var SessionId */
    private $sessionId;

    public function __construct(string $path, SessionId $sessionId) {
        $this->path = $path;
        $this->sessionId = $sessionId;
    }

    public function renderCartItems(CartItemCollection $cartItems) {
        $current = $this->loadProjection();
        $current['items'] = $cartItems;
        $this->persist($current);
    }

    public function renderBillingAddress(BillingAddress $address) {
        $current = $this->loadProjection();
        $current['address'] = $address;
        $this->persist($current);
    }

    private function loadProjection(): array {
        $fname = $this->buildFilename();
        if (!file_exists($fname)) {
            return [
                'items' => null,
                'address' => null
            ];
        }

        return \unserialize(\file_get_contents($fname));
    }

    private function buildFilename(): string {
        return sprintf(
            '%s/%s-confirm.html',
            $this->path,
            $this->sessionId->asString()
        );
    }

    private function persist(array $current): void {
        file_put_contents(
            $this->buildFilename(),
            \serialize($current)
        );
    }

}
