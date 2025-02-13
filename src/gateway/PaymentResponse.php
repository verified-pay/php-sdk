<?php
namespace Vpay\VerifiedPay;

class PaymentResponse {
    public int $id = 0;
    public string $tx_id = '';
    public float $amount_fiat = 0.0;
    public string $status = '';
    public string $fiat_currency = '';
    public float $amount_gateway = 0.0;
    public string $gateway_currency = '';
    public string $coupon_code = '';
    public string $description = '';
    public string $callback_url = '';
    public string $return_url = '';
    public string $referer = '';
    public string $user_agent = '';
    public string $email = '';
    public string $created_at = '';
    public string $paid = '';
    public string $redeemed = '';
    public string $refunded = '';
    public int $remaining_time = 0;
    public int $expiration = 0;
    public string $payment_link = '';
    public string $qr_url = '';

	public static function fromJson($json): PaymentResponse {
		$instance = new PaymentResponse();
		foreach ($json as $key => $value) {
			if (isset($instance->$key))
				$instance->$key = $value;
		}
		return $instance;
	}
}