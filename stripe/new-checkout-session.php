<?php

    session_start();

    require_once('stripe-php-7.86.0/init.php');

    $priceId = $_POST['priceId'];

    $stripe = new \Stripe\StripeClient(
        'sk_live_ZG8bOYWkUAJC6Tg4xQ0Y5y0200ecPBG8LD'
    );

    $stripe_session = $stripe->checkout->sessions->create([
        'success_url' => 'https://www.mike-worden.com/tradersheet/?checkoutsuccessurl&session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'https://www.mike-worden.com/tradersheet/?checkoutcancelurl',
        'payment_method_types' => ['card'],
        'line_items' => [
        [
            'price' => $priceId,
            'quantity' => 1,
        ],
        ],
        'mode' => 'subscription',
        'subscription_data' => [
            'trial_period_days' => 7,
        ],
        'client_reference_id' => $_SESSION['uid'],
    ]);

    echo $stripe_session->id;