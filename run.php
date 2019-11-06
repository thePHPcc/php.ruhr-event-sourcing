<?php declare(strict_types = 1);
namespace Eventsourcing;

require __DIR__ . '/src/autoload.php';

$cartItems = new CartItemCollection();
$cartItems->add(new CartItem(1, 'foo', 123));


$log = new EventLog();

$checkout = new Checkout($log);
$checkout->start($cartItems);
$log = $checkout->changes();

// -....-

$checkout = new Checkout($log);
$checkout->setBillingAddress(new BillingAddress());

var_dump($checkout->changes());
