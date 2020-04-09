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

## License

This project is licensed under the MIT License
