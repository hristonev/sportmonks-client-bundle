# SportMonks API Client Library

## API Version support

This API Client supports SportMonks v2.0.

## Requirements

### Installation

`composer require hristonev/sportmonks-client-bundle`

## Configuration

``` php
// Bootstrap
require 'vendor/autoload.php';

use SportMonks\API\HttpClient as SportMonksAPI;

// Default values. Can be initialized without arguments.
$scheme = 'https';
$hostname = 'sportmonks.com';
$subDomain = 'soccer';
$port = 443;

// Auth.
$token = 'open sesame';

$client = new SportMonksAPI();

// Set auth.
$client->setAuth(Auth::BASIC, [
    'token' => $token
]);
```

## Usage example

### Paginated resource
``` php
$data = [];
do{
    $data = array_merge($data, $client->countries()->findAll());
}while($client->countries()->nextPage());
print_r($data);
```