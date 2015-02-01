<?php

require '../vendor/autoload.php';

$config = require 'config.php';

use Jump24\FitBit\FitBitBody;

$body = new FitBitBody($config['consumer_key'], $config['consumer_secret']);

$body->setAccessCredentials($_SESSION['token'], $_SESSION['secret']);

$body->dumpCallData();

$measurements = $body->getBodyWeightForPeriod('2015-02-01', '1w');

print_r($measurements);

die();
