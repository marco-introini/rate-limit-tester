<?php

use Jfcherng\Utility\CliColor;


function mainTitle(string $string): void {
    $header = "===========================================================================";
    echo CliColor::color($header.PHP_EOL.$string.PHP_EOL.$header.PHP_EOL, 'f_yellow');
}

function okMessage(string $string): void {
    echo CliColor::color($string.PHP_EOL, 'f_green');
}

function errorMessage($message):void {
    echo CliColor::color($message.PHP_EOL, 'f_red');
}