# Load Test

A super simple Soap API rate limit tester in PHP with x509 certificate usage.

It requires [GuzzlePHP](https://docs.guzzlephp.org/en/stable/) 

## Installation

- clone the repository
- copy .env.example in .env
- create correct soap envelope in a file defined in BODYFILE
- create a correct x509 certificate for the request
- modify the .env file with correct information

Inside .env you can set:

- URL = FQDN for the request (e.g https://www.example.com)
- PATH = path of the soap web service (e.g. /mysoap.ws )
- NUMBEROFCONCURRENTREQUESTS = number of concurrent requests
- BODYFILE = the file containing the soap envelope to send
- CERTIFICATE = file of certificate
- SOAPACTION = soapaction to send in the request headers

## Rate Limit Tester

now execute inside the src directory

```php
php rateLimitTest.php
```

