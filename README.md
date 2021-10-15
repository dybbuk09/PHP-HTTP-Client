## PHP HTTP Client

A simple and easy to implement wrapper for PHP cURL.

### Requirements

- PHP 7.4 or higher
- Composer for installation

### Supported Methods:
- GET
- POST
- PUT
- PATCH
- DELETE

### Installation
composer require hraw/httpclient

### Implementation

```php
<?php

use Curl\HttpClient;

$response = HttpClient::get('https://jsonplaceholder.typicode.com/todos')->send();
```
In response, it returns the instance of CurlResponse class.
```php
<?php

//Get the data returned by api
$response->data();

//Get status code
$response->statusCode();

//Check if response received is success response or not
$response->success();

//Get all the properties returned in response
$response->properties();
```
You can also add headers and timeout value while doing the curl request
```php
HttpClient::get($url)
            ->timeout(60)
            ->headers([
                'Content-Type : application/json',
                'Authorization : Bearer {token}'
            ])
            ->send();
```
POST Request
```php
HttpClient::post($url, $data)->send();
```
- PUT and PATCH method has same implementations as POST method.
- DELETE method has same implementation as GET method.