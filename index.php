<?php
// Include configuration file  
require_once 'php/config.php';

// Include the database connection file 
include_once 'php/dbConnect.php';

// Fetch plans from the database 
// $sqlQ = "SELECT * FROM plans";
// $stmt = $db->prepare($sqlQ);
// $stmt->execute();
// $stmt->store_result();
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
    <script src="https://js.stripe.com/v3/"></script>
    <script src="js/checkout.js" STRIPE_PUBLISHABLE_KEY="<?php echo STRIPE_PUBLISHABLE_KEY; ?>" defer></script>
    <!-- <script src="js/customers.js" defer></script> -->
    <script src="js/prices.js" defer></script>
    <link rel="stylesheet" href="css/main.css" />

</head>

<body>
    <header>
        <span id="username">
            <? $_SESSION['username'] ?>
        </span>
        <!-- SIGN UP -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signupModal">
            Sign Up
        </button>
        <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Sign Up</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="signupForm">
                            <div class="mb-3">
                                <label for="signupFormUsernameInput" class="form-label">Username</label>
                                <input type="text" class="form-control" id="signupFormUsernameInput" placeholder="John"
                                    name="username">
                            </div>
                            <div class="mb-3">
                                <label for="signupFormEmailInput" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="signupFormEmailInput"
                                    placeholder="john@example.com" name="email">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Sign Up</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- LOG IN -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
            Log In
        </button>
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Log In</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Log In</button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="products">
        <div class="product">
            <div class="img-wrapper"><img src="images/beginer_gift.png" alt=""></div>
            <div class="text">
                <h3 class="title">Beginer</h3>
                <p class="description">Short description that describes this product for</p>
            </div>
            <div><span class="cost">$8</span><span class="period">/per month</span></div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal"
                data-bs-price="beginer" data-bs-planId="1">Subscribe</button>
            <div>
                <p>This includes:</p>
                <ul>
                    <li>Up to 3 boards</li>
                    <li>Up to 10 seats</li>
                </ul>
            </div>
        </div>
        <div class="product">
            <div class="img-wrapper"><img src="images/professional_gift.png" alt=""></div>
            <div class="text">
                <h3 class="title">Professional</h3>
                <p class="description">Short description that describes this product for</p>
            </div>
            <div><span class="cost">$24</span><span class="period">/per month</span></div>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal"
                data-bs-price="professional" data-bs-planId="2">Subscribe</button>

            <div>
                <p>This includes:</p>
                <ul>
                    <li>Up to 20 boards</li>
                    <li>Up to 50 seats</li>
                </ul>
            </div>
        </div>
        <div class="product">
            <div class="img-wrapper"><img src="images/enterprise_gift.png" alt=""></div>
            <div class="text">
                <h3 class="title">Enterprise</h3>
                <p class="description">Short description that describes this product for</p>
            </div>
            <div><span class="cost">$42</span><span class="period">/per month</span></div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal"
                data-bs-price="enterprise" data-bs-planId="3">Subscribe</button>
            <div>
                <p>This includes:</p>
                <ul>
                    <li>Up to 50 boards</li>
                    <li>Up to 200 seats</li>
                </ul>
            </div>
        </div>
    </section>
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="checkoutModalLabel">New message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Display a subscription form -->
                <form id="subscrFrm">
                    <div class="modal-body">
                        <!-- Display status message -->
                        <div id="paymentResponse" class="hidden"></div>

                        <div class="form-group">
                            <label>NAME</label>
                            <input type="text" id="name" class="form-control" placeholder="Enter name" required=""
                                autofocus="">
                        </div>
                        <div class="form-group">
                            <label>EMAIL</label>
                            <input type="email" id="email" class="form-control" placeholder="Enter email" required="">
                        </div>

                        <div class="form-group">
                            <label>CARD INFO</label>
                            <div id="card-element">
                                <!-- Stripe.js will create card input elements here -->
                            </div>
                        </div>
                        <input type="hidden" id="subscr_plan" value="1">
                        <!-- Form submit button -->
                    </div>
                    <div class="modal-footer">
                        <button id="submitBtn" class="btn btn-success">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="buttonText">Proceed</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>