<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../php/secrets.php';
require_once '../php/connect.php';

$stripe = new \Stripe\StripeClient($stripeSecretKey);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the request body and decode it as JSON.
    $body = file_get_contents('php://input');
    $json = json_decode($body);

    // Get the customer ID from the cookie and the price ID from the JSON data.
    $customer_id = 'cus_PGrG67ChxwJJn4';
    $price_id = $json->price_id;

    // Create the subscription with the customer ID, price ID, and necessary options.
    $subscription = $stripe->subscriptions->create([
        'customer' => $customer_id,
        'items' => [[
            'price' => $price_id,
        ]],
        'payment_behavior' => 'default_incomplete',
        'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
        'expand' => ['latest_invoice.payment_intent'],
    ]);

    // Return the subscription ID and client secret as a JSON response.
    header('Content-Type: application/json');
    echo json_encode([
        'subscriptionId' => $subscription->id,
        'clientSecret' => $subscription->latest_invoice->payment_intent->client_secret,
    ]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="js/checkout.js" defer></script>
</head>

<body>
    <form id="payment-form">
        <div id="payment-element">
            <!-- Elements will create form elements here -->
        </div>
        <button id="submit">Submit</button>
        <div id="error-message">
            <!-- Display error message to your customers here -->
        </div>
    </form>

</html>