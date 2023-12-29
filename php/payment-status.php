<?php
// Include the configuration file  
require_once '../php/config.php';

// Include the database connection file  
require_once '../php/dbConnect.php';

$payment_id = $statusMsg = '';
$status = 'error';

// Check whether the subscription ID is not empty 
if (!empty($_GET['sid'])) {
    $subscr_id = base64_decode($_GET['sid']);

    // Fetch subscription info from the database 
    $sqlQ = "SELECT S.id, S.stripe_subscription_id, S.paid_amount, S.paid_amount_currency, S.plan_interval, S.plan_interval_count, S.plan_period_start, S.plan_period_end, S.customer_name, S.customer_email, S.status, P.name as plan_name, P.price as plan_amount FROM user_subscriptions as S LEFT JOIN plans as P On P.id = S.plan_id WHERE S.id = ?";
    $stmt = $db->prepare($sqlQ);
    $stmt->bind_param("i", $subscr_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Subscription and transaction details 
        $stmt->bind_result($subscription_id, $stripe_subscription_id, $paid_amount, $paid_amount_currency, $plan_interval, $plan_interval_count, $plan_period_start, $plan_period_end, $customer_name, $customer_email, $subscr_status, $plan_name, $plan_amount);
        $stmt->fetch();

        $status = 'success';
        $statusMsg = 'Your Subscription Payment has been Successful!';
    } else {
        $statusMsg = "Transaction has been failed!";
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe to a cool new product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/main.css" />

</head>

<body>
    <div class="container">
        
                <?php if (!empty($subscription_id)) { ?>
                    <h1 class="<?php echo $status; ?>">
                        <?php echo $statusMsg; ?>
                    </h1>
                    <div class="row">
            <div class="col-md-6 offset-md-4">
                    <h4>Payment Information</h4>
                    <p><b>Reference Number:</b>
                        <?php echo $subscription_id; ?>
                    </p>
                    <p><b>Subscription ID:</b>
                        <?php echo $stripe_subscription_id; ?>
                    </p>
                    <p><b>Paid Amount:</b>
                        <?php echo $paid_amount . ' ' . $paid_amount_currency; ?>
                    </p>
                    <p><b>Status:</b>
                        <?php echo $subscr_status; ?>
                    </p>

                    <h4>Subscription Information</h4>
                    <p><b>Plan Name:</b>
                        <?php echo $plan_name; ?>
                    </p>
                    <p><b>Amount:</b>
                        <?php echo $plan_amount . ' ' . STRIPE_CURRENCY; ?>
                    </p>
                    <p><b>Plan Interval:</b>
                        <?php echo ($plan_interval_count > 1) ? $plan_interval_count . ' ' . $plan_interval . 's' : $plan_interval; ?>
                    </p>
                    <p><b>Period Start:</b>
                        <?php echo $plan_period_start; ?>
                    </p>
                    <p><b>Period End:</b>
                        <?php echo $plan_period_end; ?>
                    </p>

                    <h4>Customer Information</h4>
                    <p><b>Name:</b>
                        <?php echo $customer_name; ?>
                    </p>
                    <p><b>Email:</b>
                        <?php echo $customer_email; ?>
                    </p>
                <?php } else { ?>
                    <h1 class="error">Your Transaction been failed!</h1>
                    <p class="error">
                        <?php echo $statusMsg; ?>
                    </p>
                <?php } ?>
            </div>
        </div>
    </div>

</body>