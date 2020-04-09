<?php

include_once __DIR__ . '/../src/SimpleCurl.php';

use SimpleCurl\SimpleCurl;

//simple get
$response = SimpleCurl::Get('https://example.com');
file_put_contents(__DIR__ . '/get.html', $response);

//simple post
$response = SimpleCurl::Post('https://postman-echo.com/post', array('data1' => 'this is the data item'));
echo ($response);