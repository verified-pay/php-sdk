<?php
define('VPAY__PLUGIN_DIR', realpath(dirname(__FILE__) . '/../') . '/');

// values from your account: https://verified-pay.com/account
$publicToken = '';
$secretToken = '';
$siteUrl = 'http://your-domain.com/';

// vpay includes
require_once VPAY__PLUGIN_DIR . 'src/gateway/VerifiedPayGateway.php';