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

## GET Method

```
$response = SimpleCurl\SimpleCurl::Get('http://example.com')
```

## POST Method

```
$response = SimpleCurl\SimpleCurl::Post('http://example.com',array('param1' => 'Data of param 1','param_2' => 'Data 2'));
```

## License

This project is licensed under the MIT License
