<?php

include_once __DIR__ . '/../src/SimpleCurl.php';

use SimpleCurl\SimpleCurl;

//simple get
$response = SimpleCurl::Get('https://example.com');
file_put_contents(__DIR__ . '/get.html', $response);

//simple post
$params = array(
    'string' => 'text param can be passed',
    'int' => 100,
    'float' => 100.59,
    'date' => '2020-04-09',
    'time' => '2020-04-19T12:00:00'
);
$response = SimpleCurl::Post('https://postman-echo.com/post', $params);

//complex post
$params = array(
    'string' => 'text param can be passed',
    'int' => 100,
    'float' => 100.59,
    'date' => '2020-04-09',
    'time' => '2020-04-19T12:00:00'
);
$cookieFilePath = __DIR__ . '/cookie.txt';

$externalHeaders = array(
    'x-api-key' => 'API key of the request ...',
    'x-password' => 'If needed'
);

$curlOptions = array(
    //this will not work because the option is not correct. Need to change to the correct option
    ANY_PHP_CURL_OPTION => 'Value'
);

$response = SimpleCurl::Post(
    'https://postman-echo.com/post',
    $params,
    $cookieFilePath,
    $externalHeaders,
    $curlOptions
);
