<?php declare(strict_types = 1);
namespace Eventsourcing;

require __DIR__ . '/src/autoload.php';

$sid = new SessionId('has4t1glskcktjh4ujs9eet26u');

$cartService = new CartService();
$cartItems = $cartService->getCartItems($sid);

$writer = new FileSystemEventLogWriter('/tmp/checkout.events');
$reader = new FileSystemEventLogReader('/tmp/checkout.events');

$checkout = new Checkout(new EventLog());
$checkout->start($cartItems);

$writer->write($checkout->changes());

$checkout = new Checkout($reader->read());
$checkout->setBillingAddress(new BillingAddress());

$writer->write($checkout->changes());

var_dump($checkout->changes());

