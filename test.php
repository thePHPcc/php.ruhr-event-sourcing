<?php declare(strict_types = 1);
namespace Eventsourcing;

require __DIR__ . '/src/autoload.php';

$reader = new FileSystemEventLogReader('/tmp/checkout/snapshot');

$checkout = new Checkout(
    $reader->read(new EmitterId('ba04da34-334a-4171-a2f5-7b59d74fe492'))
);

var_dump($checkout);
