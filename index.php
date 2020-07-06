<?php
// Copyright (c) 2018-2020 The CYBAVO developers
// All Rights Reserved.
// NOTICE: All information contained herein is, and remains
// the property of CYBAVO and its suppliers,
// if any. The intellectual and technical concepts contained
// herein are proprietary to CYBAVO
// Dissemination of this information or reproduction of this materia
// is strictly forbidden unless prior written permission is obtained
// from CYBAVO.

include_once 'helper/apicaller.php';
include_once 'mockserver.conf.php';

date_default_timezone_set('UTC');

function log_access($uri, $resp) {
    file_put_contents('php://stdout', sprintf('[%s] %s %s %d', date('D M j H:i:s Y'),
        $uri, json_encode(json_decode($resp['result'])), $resp['status'])."\n");
}

function log_text($uri, $text) {
    file_put_contents('php://stdout', sprintf('[%s] %s %s', date('D M j H:i:s Y'), $uri, $text)."\n");
}

function get_query_params() {
    $params = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);
    return explode('&', $params);
}

function response($resp)
{
    header_remove();
    http_response_code($resp['status']);
    header('Content-Type: application/json');
    return json_encode(json_decode($resp['result']));
}

function response_plaintext($status_code, $text)
{
    header_remove();
    http_response_code($status_code);
    return $text;
}

function base64url_encode($data) {
    return strtr(base64_encode($data), '+/', '-_');
} 

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$post_data = file_get_contents('php://input');
$query = get_query_params();

if (!strcmp($path, '/v1/mock/users')) {
    $resp = make_request($method, '/v1/api/users', $query, $post_data);
    log_access('/v1/mock/users', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/devices')) {
    $resp = make_request($method, '/v1/api/devices', get_query_params(), $post_data);
    if ($method === 'POST') {
        $resp['result'] = str_replace('\u0026', '&', urldecode($resp['result']));
    }
    log_access('/v1/mock/devices', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/devices/2fa')) {
    $resp = make_request($method, '/v1/api/devices/2fa', $query, $post_data);
    log_access('/v1/mock/devices/2fa', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/users/pin')) {
    $resp = make_request($method, '/v1/api/users/pin', $query, $post_data);
    log_access('/v1/mock/users/pin', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/users/2fa')) {
    $resp = make_request($method, '/v1/api/users/2fa', $query, $post_data);
    log_access('/v1/mock/users/2fa', $resp);
    echo response($resp);
    return;
} else if (preg_match('/\/v1\/mock\/users\/2fa\/(?<order_id>\d+)\??/i', $path, $m)) {
    $resp = make_request($method, '/v1/api/users/2fa/'.$m['order_id'], $query, $post_data);
    log_access($m['0'], $resp);
    echo response($resp);
    return;    
} else if (!strcmp($path, '/v1/mock/users/me')) {
    $resp = make_request($method, '/v1/api/users/me', $query, $post_data);
    log_access('/v1/mock/users/me', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/order/status')) {
    $resp = make_request($method, '/v1/api/order/status', $query, $post_data);
    log_access('/v1/mock/order/status', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/users/totpverify')) {
    $resp = make_request($method, '/v1/api/users/totpverify', $query, $post_data);
    log_access('/v1/mock/users/totpverify', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/users/emailotp')) {
    $resp = make_request($method, '/v1/api/users/emailotp', $query, $post_data);
    log_access('/v1/mock/users/emailotp', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/users/emailotp/verify')) {
    $resp = make_request($method, '/v1/api/users/emailotp/verify', $query, $post_data);
    log_access('/v1/mock/users/emailotp/verify', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/users/info/email')) {
    $resp = make_request($method, '/v1/api/users/info/email', $query, $post_data);
    log_access('/v1/mock/users/info/email', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/users/info/verify')) {
    $resp = make_request($method, '/v1/api/users/info/verify', $query, $post_data);
    log_access('/v1/mock/users/info/verify', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/users/edit')) {
    $resp = make_request($method, '/v1/api/users/edit', $query, $post_data);
    log_access('/v1/mock/users/edit', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/users/remove')) {
    $resp = make_request($method, '/v1/api/users/remove', $query, $post_data);
    log_access('/v1/mock/users/remove', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/healthy')) {
    $resp = make_request($method, '/v1/api/healthy', $query, $post_data);
    log_access('/v1/mock/healthy', $resp);
    echo response($resp);
    return;
} else if (!strcmp($path, '/v1/mock/callback')) {
    $header_checksum = $_SERVER['HTTP_X_CHECKSUM'];
    $payload = $post_data.$GLOBALS['api_secret'];
    $checksum = base64url_encode(hash('sha256', $payload, true));
    log_text('/v1/mock/callback',
        "header_checksum: ".$header_checksum." <-> checksum: ".$checksum."\npayload: ".$post_data);
    if (!strcmp($header_checksum, $checksum)) {
        echo response_plaintext(200, 'OK');
    } else {
        echo response_plaintext(400, 'Bad checksum');
    }
    return;
}

$resp['status'] = 404;
$resp['result'] = '{"result": "invalid path"}';
log_access($path, $resp);
echo response($resp);

?>

