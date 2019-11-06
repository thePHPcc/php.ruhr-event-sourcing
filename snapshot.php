<?php declare(strict_types = 1);
namespace Eventsourcing;

require __DIR__ . '/src/autoload.php';

$snapshotter = new Snapshotter(
    new FileSystemEventLogReader('/tmp/checkout'),
    new FileSystemEventLogWriter('/tmp/checkout/snapshot')
);

$snapshotter->snapshot(
    new EmitterId('ba04da34-334a-4171-a2f5-7b59d74fe492')
);
