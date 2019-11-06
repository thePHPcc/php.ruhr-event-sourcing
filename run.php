<?php declare(strict_types = 1);
namespace Eventsourcing;

require __DIR__ . '/src/autoload.php';

$sid = new SessionId('has4t1glskcktjh4ujs9eet26u');

$checkoutService = new CheckoutService(
    new CartService(),
    new SessionService($sid),
    new FileSystemEventLogWriter('/tmp/checkout'),
    new FileSystemEventLogReader('/tmp/checkout')
);

$checkoutService->start();

$checkoutService->defineBillingAddress(new BillingAddress());


