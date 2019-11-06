<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'eventsourcing\\billingaddress' => '/domain/BillingAddress.php',
                'eventsourcing\\billingaddresssetevent' => '/domain/BillingAddressSetEvent.php',
                'eventsourcing\\cartitem' => '/domain/CartItem.php',
                'eventsourcing\\cartitemcollection' => '/domain/CartItemCollection.php',
                'eventsourcing\\cartnotfoundexception' => '/domain/CartNotFoundException.php',
                'eventsourcing\\cartservice' => '/CartService.php',
                'eventsourcing\\checkout' => '/Checkout.php',
                'eventsourcing\\checkoutstartedevent' => '/domain/CheckoutStartedEvent.php',
                'eventsourcing\\event' => '/domain/Event.php',
                'eventsourcing\\eventlog' => '/domain/EventLog.php',
                'eventsourcing\\sessionid' => '/domain/SessionId.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    },
    true,
    false
);
// @codeCoverageIgnoreEnd
