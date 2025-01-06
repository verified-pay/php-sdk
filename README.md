# Verified Pay integration examples
This repository contains code examples of how to integrate [Verified Pay](https://verified-pay.com/)
as a Credit Card payment processor in your backend.


## PHP
See the `index.php` in [php](php) folder.

This example registeres a customer with Verified Pay and then processes a credit card payment via iFrame.

#### Installation
In the `config.php` file, add the following:
- your Account `$publicToken`, `$secretToken` and `$siteUrl`.

In the `index.php` file, add the following:
- customize payment amount, currency and other parameters as needed


## WordPress
Just download our [WordPress plugin](https://wordpress.org/plugins/verified-pay-credit-card-payments/).

You can install it directly within WordPress under Plugins -> Add New


## Payment Control flow
``` text 
     +-------------+                      +-------------+                      +-------------+
     |             |                      |   Merchant  |                      | VerifiedPay |
     |   Customer  |                      |   Website   |                      | Payment     |
     |             |                      |             |                      | Gateway     |
     +-------------+                      +-------------+                      +-------------+
            |                                     |                                   |
            |--(1)--Payment Request-------------->|                                   |
            |                                     |                                   |
            |<--(2)--Generate Payment Form--------|                                   |
            |                                     |                                   |
            |---(3)--Click "Pay" & Show iFrame of Gateway---------------------------->|
            |                                     |                                   |
            |---(4)--Enter Credit Card information----------------------------------->|
            |                                     |                                   |
            |                                     |<---(5)--Payment Success Callback--|
            |                                     |                                   |
            |<---------------------------------(6)--Send Customer back to Return URL--|
            |                                     |                                   |
            |                                     |                                   |
```


## Contact
[Website](https://verified-pay.com/) -
