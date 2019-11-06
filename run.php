<?php declare(strict_types = 1);
namespace Eventsourcing;

require __DIR__ . '/src/autoload.php';

$sid = new SessionId('has4t1glskcktjh4ujs9eet26u');

$sessionService = new SessionService($sid);

$dispatcher = new EventDispatcher();
$dispatcher->addListener(
    new CheckoutStartedListener(
        $sessionService
    )
);

$checkoutService = new CheckoutService(
    new CartService(),
    $sessionService,
    new FileSystemEventLogWriter('/tmp/checkout'),
    new FileSystemEventLogReader('/tmp/checkout'),
    $dispatcher
);

$checkoutService->start();

$checkoutService->defineBillingAddress(new BillingAddress());


