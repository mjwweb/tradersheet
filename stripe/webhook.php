<?php

    // webhook response functions -> save responses to database

    function checkout_completed($customer_id, $user_id) {
        require '../Includes/dbh.inc.php';
        $accountStatus = 'trialing';
        $stmt = $conn->prepare('UPDATE users SET customer_id = ?, account_status = ? WHERE uid = ?');
        $stmt->bind_param('sss', $customer_id, $accountStatus, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    function subscription_updated($customer_id, $account_status) {
        require '../Includes/dbh.inc.php';
        $stmt = $conn->prepare('UPDATE users SET account_status=? WHERE customer_id=?');
        $stmt->bind_param('ss', $account_status, $customer_id);
        $stmt->execute();
        $stmt->close();
    }

    function invoice_failed($customer_id, $user_id) {
        require '../Includes/dbh.inc.php';
    }

    // webhook

    require_once('stripe-php-7.86.0/init.php');

    \Stripe\Stripe::setApiKey('sk_live_ZG8bOYWkUAJC6Tg4xQ0Y5y0200ecPBG8LD');

    $endpoint_secret = 'whsec_FVkPbTQFwI3zaN6wWGKpQ02j8QhdcjW4';

    $payload = @file_get_contents('php://input');
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
    $event = null;

    try {
        $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
        );
    } 
    catch(\UnexpectedValueException $e) {
        // Invalid payload
        http_response_code(400);
        exit();
    } 
    catch(\Stripe\Exception\SignatureVerificationException $e) {
        // Invalid signature
        http_response_code(400);
        exit();
    }

    // Handle the event
    switch ($event->type) {
        case 'checkout.session.completed':
            $customer_id = $event->data->object->customer;
            $user_id = $event->data->object->client_reference_id;
            checkout_completed($customer_id, $user_id);
            break;
        case 'customer.subscription.updated':
            $customer_id = $event->data->object->customer;
            $account_status = $event->data->object->status;
            subscription_updated($customer_id, $account_status);
            break;
        case 'invoice.payment_failed':
            invoice_failed();
            break;
        default:
            echo 'Received unknown event type ' . $event->type;
    }

    http_response_code(200);