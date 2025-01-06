<?php
// This file gets called when the payment status changes (paid or expired).
require_once 'config.php';
require_once 'functions.php';

// The content type to respond is ignored by Verified Pay but you should return HTTP Status Code 200
header('Content-Type: text/plain; charset=UTF-8');
echo "ok"; // any response is fine (ignored by Verified Pay)

// Read the application/json POST data.
// Afterward you can access JSON variables like $post['payment']['status']
// similar to $_POST for url-encoded form data.
$post = json_decode(file_get_contents('php://input'), true);

if (empty($post)) {
    echo "no data received";
    return;
}

// check if the payment is complete
if ($post['token'] === $secretToken) { // prevent spoofing
    if ($post['payment']['status'] === 'PAID') {
        // Payment complete. Update your database and ship your order.
    }
    else if ($post['payment']['status'] === 'DECLINED') {
        // The customer was unable to complete the payment due to our fraud checks or insufficient funds.
    }
}

// Write the callback JSON to a file for debugging. You can remove this for production.
if (file_put_contents("./callback-payment.json", json_encode($post)) === false)
    echo "error writing callback file";
else
    echo "written callback";
?>
