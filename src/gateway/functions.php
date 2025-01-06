<?php
namespace Vpay\VerifiedPay;

function wp_remote_post_curl($url, $args = array()) {
    $defaults = array(
        'method'    => 'POST',
        'body'      => '',
        'headers'   => array(),
        'timeout'   => 5,
    );
    $args = wp_parse_args_vpay($args, $defaults);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $args['timeout']);

    if ($args['method'] === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args['body']);
    }

    if (!empty($args['headers'])) {
        $headers = array();
        foreach ($args['headers'] as $key => $value) {
            $headers[] = "$key: $value";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    $response_body = curl_exec($ch);
    $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error         = curl_error($ch);

    curl_close($ch);

    if ($error) {
        return new \Exception('http_request_failed', $error);
    }

    return array(
        'response' => array(
            'code' => $response_code,
        ),
        'body'    => $response_body,
    );
}

function wp_remote_get_curl($url, $args = array()) {
    $defaults = array(
        'headers'   => array(),
        'timeout'   => 5,
    );
    $args = wp_parse_args_vpay($args, $defaults);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $args['timeout']);

    if (!empty($args['headers'])) {
        $headers = array();
        foreach ($args['headers'] as $key => $value) {
            $headers[] = "$key: $value";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    $response_body = curl_exec($ch);
    $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error         = curl_error($ch);

    curl_close($ch);

    if ($error) {
        return new \Exception('http_request_failed', $error);
    }

    return array(
        'response' => array(
            'code' => $response_code,
        ),
        'body'    => $response_body,
    );
}

/**
 * Merges user defined arguments into defaults array.
 *
 * This function is used throughout WordPress to allow for both string or array
 * to be merged into another array.
 *
 * @since 2.2.0
 * @since 2.3.0 `$args` can now also be an object.
 *
 * @param string|array|object $args     Value to merge with $defaults.
 * @param array               $defaults Optional. Array that serves as the defaults.
 *                                      Default empty array.
 * @return array Merged user defined values with defaults.
 */
function wp_parse_args_vpay( $args, $defaults = array() ) {
    if ( is_object( $args ) ) {
        $parsed_args = get_object_vars( $args );
    } elseif ( is_array( $args ) ) {
        $parsed_args =& $args;
    } else {
        wp_parse_str( $args, $parsed_args );
    }

    if ( is_array( $defaults ) && $defaults ) {
        return array_merge( $defaults, $parsed_args );
    }
    return $parsed_args;
}