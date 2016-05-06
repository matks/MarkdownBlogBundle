<?php

$vendorAutoloadFile = __DIR__ . '/../../../../../vendor/autoload.php';

if (false === file_exists($vendorAutoloadFile)) {
    throw new \RuntimeException('Could not find vendor autoload file');
}
$loader = require $vendorAutoloadFile;
