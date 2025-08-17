<?php

declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

echo "Xdebug version: " . phpversion('xdebug') . "\n";
var_dump("Debug Test Start");

if (!extension_loaded('xdebug')) {
    die('Xdebug is not loaded!');
}

xdebug_break();
var_dump("After Break");