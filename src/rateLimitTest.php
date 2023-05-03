<?php

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use MintDev\LoadTester\ReadEnv;

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/ReadEnv.php';
require __DIR__.'/formatCli.php';

new ReadEnv(__DIR__.'/..');

$url = $_ENV['URL'];
$path = $_ENV['PATH'];
$numberOfConcurrentRequests = $_ENV['NUMBEROFCONCURRENTREQUESTS'];
$bodyFile = $_ENV['BODYFILE'];
$certificate = $_ENV['CERTIFICATE'];
$soapAction = $_ENV['SOAPACTION'];

$client = new Client([
    'base_uri' => $url,
    'timeout' => 30.0,
    'verify' => false,
    'cert' => $certificate
]);

$body = file_get_contents($bodyFile);

$requests = [];

for ($i = 1; $i <= $numberOfConcurrentRequests; $i++) {
    $requests[] = $client->postAsync($path,[
        'body' => $body,
        'headers' => [
            'Content-type' => 'text/xml',
            'SoapAction' => $soapAction,
        ]
    ]);
}

$results = Promise\Utils::settle($requests)->wait();

$numSuccesses = 0;
$numFailures = 0;

foreach ($results as $result) {
    if ($result['state'] === 'fulfilled') {
        $numSuccesses++;
        $response = $result['value'];
        $statusCode = $response->getStatusCode();
        // Handle the response
        echo "Request succeeded with status code $statusCode".PHP_EOL;
    } else {
        $numFailures++;
        $exception = $result['reason'];
        // Handle the exception
        echo "Request failed with status code ".$exception->getCode().PHP_EOL;
        echo "Error message ".$exception->getMessage().PHP_EOL;
    }
}

mainTitle("SUMMARY FOR ".$url.$path);
okMessage( "# of success: {$numSuccesses} of {$numberOfConcurrentRequests}");
errorMessage("# of failures: {$numFailures} of {$numberOfConcurrentRequests}");
