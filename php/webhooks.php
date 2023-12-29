<?php
// Include the configuration file 
require_once '../php/config.php'; 
    
// Include the database connection file 
include_once '../php/dbConnect.php'; 
 
// Include the Stripe PHP library 
require_once '../vendor/autoload.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);

// Replace this endpoint secret with your endpoint's unique secret
// If you are testing with the CLI, find the secret by running 'stripe listen'
// If you are using an endpoint defined with the API or dashboard, look in your webhook settings
// at https://dashboard.stripe.com/webhooks
$endpoint_secret = 'whsec_YYQn02L3QKIzhjCOFiBSiFIkcSAJTuOH';

$payload = @file_get_contents('php://input');
$event = null;
try {
    $event = \Stripe\Event::constructFrom(
        json_decode($payload, true)
    );
} catch (\UnexpectedValueException $e) {
    // Invalid payload
    echo '⚠️  Webhook error while parsing basic request.';
    http_response_code(400);
    exit();
}
// Handle the event
switch ($event->type) {
    case 'customer.subscription.trial_will_end':
        $subscription = $event->data->object; // contains a \Stripe\Subscription
        // Then define and call a method to handle the trial ending.
        // handleTrialWillEnd($subscription);
        break;
    case 'customer.subscription.created':
        $subscription = $event->data->object; // contains a \Stripe\Subscription
        $sql = "INSERT INTO `customers` (`id`, `email`, `name`) VALUES (NULL, `aaaaaa@aaaa.com`, `ff`)";
        $result = mysqli_query($link, $sql);
        break;
    case 'customer.subscription.deleted':
        $subscription = $event->data->object; // contains a \Stripe\Subscription
        // Then define and call a method to handle the subscription being deleted.
        // handleSubscriptionDeleted($subscription);
        break;
    case 'customer.subscription.updated':
        $subscription = $event->data->object; // contains a \Stripe\Subscription
        // Then define and call a method to handle the subscription being updated.
        // handleSubscriptionUpdated($subscription);
        break;
    default:
        // Unexpected event type
        echo 'Received unknown event type';
}