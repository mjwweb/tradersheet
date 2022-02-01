
<?php

    session_start();

    if (isset($_SESSION['customer_id']) && isset($_SESSION['uid'])) {

        require_once('stripe-php-7.86.0/init.php');

        \Stripe\Stripe::setApiKey('sk_live_ZG8bOYWkUAJC6Tg4xQ0Y5y0200ecPBG8LD');
    
        $session = \Stripe\BillingPortal\Session::create([
            'customer' => $_SESSION['customer_id'],
            'return_url' => 'https://www.mike-worden.com/tradersheet',
        ]);
    
        // Redirect to the customer portal.
        echo $session->url;
        exit();

    }