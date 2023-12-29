<?php
// Set your secret key. Remember to switch to your live secret key in production.
// See your keys here: https://dashboard.stripe.com/apikeys
require_once '../vendor/autoload.php';
require_once '../php/secrets.php';
require_once '../php/connect.php';
session_start();

$stripe = new \Stripe\StripeClient($stripeSecretKey);

$stripe->customers->create([
    'email' => $_POST['email'],
    'name' => $_POST['username'],

]);

$sql = "INSERT INTO `customers` (`id`, `email`, `name`) VALUES (NULL, '" . $_POST['email'] . "', '" . $_POST['username'] . "')";

$result = mysqli_query($link, $sql);


header('Content-Type: application/json');
echo json_encode(['username' => $_POST['username']]);


