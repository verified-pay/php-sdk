<?php
require_once 'config.php';
require_once 'functions.php';

use Vpay\VerifiedPay\Customer;
use Vpay\VerifiedPay\VerifiedPayGateway;
use Vpay\VerifiedPay\VerifiedPayPaymentParams;
use Vpay\VerifiedPay\Product;


$gateway = new VerifiedPayGateway($publicToken, $secretToken, $siteUrl);

// 1. register customer (can be called for existing/returning customers too)
$customer = new Customer();
$customer->phone = '+27123456789'; // required field
$customer->email = 'new-verifiedpay-customer@gmail.com'; // required field
$customer->firstName = 'John'; // optional
$customer->lastName = 'Doe'; // optional
$customer->addressLine1 = '123 Main St';
$customer->city = 'Cape Town';
$customer->state = 'WC';
$customer->country = 'ZA';

try {
    $registerRes = $gateway->registerCustomer( $customer );
}
catch ( \Exception $e ) {
    echo 'Exception when registering customer: ' . $e->getMessage();
    die();
}

// 2. create payment link for iframe
$params = new VerifiedPayPaymentParams(
        getRandomString(12), // put your Order ID or other unique ID here (MySQL primary key or MongoDB _id)
        sprintf("%.2f", 5.65), // make sure to use string with fixed decimals to avoid floating point inconsistency
        'USD'
);
$params->type = 'Order';
$params->skipPhoneVerify = true;
$params->customerToken = $registerRes->Token;
$params->billingAddress = $customer;
$params->shippingAddress = $customer;

$product = new Product();
$product->sku = '134ABC';
$product->name = 'Test Product';
$product->price = 5.65;
$product->tax = 0.0;
$params->products[] = $product;

// Where to notify you of changes in the payment status (expired or paid).
// This must be on a public domain. The callback will not work when you are testing on localhost!
$params->callbackUrl = $siteUrl . 'callback.php';

// the URL to send the customer back to after payment. Not needed with iframe.
// Empty means customer will see "payment success" message.
//$params->returnUrl = $siteUrl . 'index.php?paid=1';

$frameUrl = $gateway->getPayFrameUrl($params);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            margin: 5px 5px 5px 5px;
        }
    </style>
    <title>Verified Pay PHP Demo</title>
</head>
<body>
<h1>Verified Pay PHP Demo</h1>

<?php if (isset($_GET['paid'])): ?>
    <p>Thanks for your payment. We will email you when your order gets shipped.</p>
<?php else: ?>
    <iframe src="<?php echo $frameUrl;?>" width="100%" height="800"></iframe>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
