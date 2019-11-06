<?php declare(strict_types = 1);
namespace Eventsourcing;

require __DIR__ . '/src/autoload.php';

$checkout = new Checkout();
$checkout->start(new CartItemCollection());
$checkout->setBillingAddress(new BillingAddress());

var_dump($checkout->eventLog());
