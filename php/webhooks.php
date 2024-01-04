<?php
// Include the configuration file 
require_once '../php/config.php';

// Include the database connection file 
include_once '../php/dbConnect.php';

// Include the Stripe PHP library 
require_once '../vendor/autoload.php';

\Stripe\Stripe::setApiKey(STRIPE_API_KEY);

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
    case 'customer.subscription.updated':
        $subscription = $event->data->object; // contains a \Stripe\Subscription
        // Then define and call a method to handle the subscription being updated.
        // handleSubscriptionUpdated($subscription);
        break;
    case 'invoice.created':
        try {
            $invoice = $event->data->object;
            $status = 'created';
            $created = date("Y-m-d H:i:s", $invoice->created);
            $sqlQ = "INSERT INTO invoices (stripe_invoice_id,stripe_subscription_id,stripe_customer_id,created,total,status) VALUES (?,?,?,?,?,?)";
            $stmt = $db->prepare($sqlQ);
            $stmt->bind_param("ssssis", $invoice->id, $invoice->subscription, $invoice->customer, $created, $invoice->total, $status);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;
    case 'invoice.payment_succeeded':
        try {
            $invoice = $event->data->object;
            $status = 'payment_succeeded';
            $sqlQ = "UPDATE `invoices` SET `status` = ?  WHERE `invoices`.`stripe_invoice_id` = ?;";
            $stmt = $db->prepare($sqlQ);
            $stmt->bind_param("ss", $status, $invoice->id);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;
    case 'payment_intent.created':
        try {
            $payment_intent = $event->data->object;
            $status = 'created';
            $created = date("Y-m-d H:i:s", $payment_intent->created);
            $sqlQ = "INSERT INTO payments (stripe_payment_id,stripe_customer_id,stripe_invoice_id,amount,currency,created,status) VALUES (?,?,?,?,?,?,?)";
            $stmt = $db->prepare($sqlQ);
            $stmt->bind_param("sssdsss", $payment_intent->id, $payment_intent->customer, $payment_intent->invoice, $payment_intent->amount, $payment_intent->currency, $created, $status);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;
    case 'payment_intent.succeeded':
        try {
            $payment_intent = $event->data->object;
            $status = 'succeeded';
            $succeeded = date("Y-m-d H:i:s", $payment_intent->succeeded);
            $sqlQ = "UPDATE `payments` SET `status` = ?, `succeeded` = ? WHERE `payments`.`stripe_payment_id` = ?;";
            $stmt = $db->prepare($sqlQ);
            $stmt->bind_param("sss", $status, $succeeded, $payment_intent->id);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;
    case 'payment_intent.payment_failed':
        try {
            $payment_intent = $event->data->object;
            $status = 'payment_failed';
            $sqlQ = "UPDATE `payments` SET `status` = ? WHERE `payments`.`stripe_payment_id` = ?;";
            $stmt = $db->prepare($sqlQ);
            $stmt->bind_param("ss", $status, $payment_intent->id);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;
    default:
        // Unexpected event type
        echo 'Received unknown event type';
}