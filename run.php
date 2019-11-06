<?php declare(strict_types = 1);
namespace Eventsourcing;

require __DIR__ . '/src/autoload.php';

$sid = new SessionId('has4t1glskcktjh4ujs9eet26u');

$factory = new Factory();
$checkoutService = $factory->createCheckoutService($sid);

$checkoutService->start();

$checkoutService->defineBillingAddress(new BillingAddress());


