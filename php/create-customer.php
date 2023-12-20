<?php
// Set your secret key. Remember to switch to your live secret key in production.
// See your keys here: https://dashboard.stripe.com/apikeys
require_once '../vendor/autoload.php';
require_once '../php/secrets.php';
require_once '../php/connect.php';


$stripe = new \Stripe\StripeClient($stripeSecretKey);

$stripe->customers->create([
    'email' => $_POST['email'],
    // 'name' => '{{CUSTOMER_NAME}}',
    'shipping' => [
        'address' => [
            'city' => 'Brothers',
            'country' => 'US',
            'line1' => '27 Fredrick Ave',
            'postal_code' => '97712',
            'state' => 'CA',
        ],
        'name' => '{{CUSTOMER_NAME}}',
    ],
    'address' => [
        'city' => 'Brothers',
        'country' => 'US',
        'line1' => '27 Fredrick Ave',
        'postal_code' => '97712',
        'state' => 'CA',
    ],
]);

$sql = "INSERT INTO `customers` (`id`, `email`, `name`) VALUES (NULL, `".$_POST['email']."`, `".$_POST['name']."`)";

$result = mysqli_query($link, $sql);
// $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($result);
echo $sql;
echo var_dump($_POST);
