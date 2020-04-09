# Use php curl to send request to server

This is the library allows to send GET/POST method to the server then get the response

## Getting Started

### Installing

Clone the source into the project

```
git clone https://github.com/locddspkt/SimpleCurl.git
```

Include the class

```
include_once '/path/to/the/file/src/SimpleCurl.php';
```

## Examples
### GET Method

```
$response = SimpleCurl\SimpleCurl::Get('http://example.com')
```

### POST Method

```
$params = array(
    'string' => 'text param can be passed', 
    'int' => 100,
    'float' => 100.59,
    'date' => '2020-04-09',
    'time' => '2020-04-19T12:00:00'
);

$response = SimpleCurl\SimpleCurl::Post('http://example.com', $params);
```
### POST with complex params
```
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
```
## License

This project is licensed under the MIT License
