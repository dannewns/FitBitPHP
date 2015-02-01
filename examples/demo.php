<?php

require '../vendor/autoload.php';

$config = require 'config.php';

use Jump24\FitBit\FitBitBody;

$body = new FitBitBody($config['consumer_key'], $config['consumer_secret'], $_SESSION['token'], $_SESSION['secret']);

$measurements = $body->getBodyMeasurements('2015-01-28');

print_r($measurements);
die();
